<?php

namespace Drupal\ata\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Url;
use Drupal\ata\Entity\LiveCodeInterface;

/**
 * Class LiveCodeController.
 *
 *  Returns responses for Live code routes.
 */
class LiveCodeController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * Displays a Live code  revision.
   *
   * @param int $live_code_revision
   *   The Live code  revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  public function revisionShow($live_code_revision) {
    $live_code = $this->entityManager()->getStorage('live_code')->loadRevision($live_code_revision);
    $view_builder = $this->entityManager()->getViewBuilder('live_code');

    return $view_builder->view($live_code);
  }

  /**
   * Page title callback for a Live code  revision.
   *
   * @param int $live_code_revision
   *   The Live code  revision ID.
   *
   * @return string
   *   The page title.
   */
  public function revisionPageTitle($live_code_revision) {
    $live_code = $this->entityManager()->getStorage('live_code')->loadRevision($live_code_revision);
    return $this->t('Revision of %title from %date', ['%title' => $live_code->label(), '%date' => format_date($live_code->getRevisionCreationTime())]);
  }

  /**
   * Generates an overview table of older revisions of a Live code .
   *
   * @param \Drupal\ata\Entity\LiveCodeInterface $live_code
   *   A Live code  object.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function revisionOverview(LiveCodeInterface $live_code) {
    $account = $this->currentUser();
    $langcode = $live_code->language()->getId();
    $langname = $live_code->language()->getName();
    $languages = $live_code->getTranslationLanguages();
    $has_translations = (count($languages) > 1);
    $live_code_storage = $this->entityManager()->getStorage('live_code');

    $build['#title'] = $has_translations ? $this->t('@langname revisions for %title', ['@langname' => $langname, '%title' => $live_code->label()]) : $this->t('Revisions for %title', ['%title' => $live_code->label()]);
    $header = [$this->t('Revision'), $this->t('Operations')];

    $revert_permission = (($account->hasPermission("revert all live code revisions") || $account->hasPermission('administer live code entities')));
    $delete_permission = (($account->hasPermission("delete all live code revisions") || $account->hasPermission('administer live code entities')));

    $rows = [];

    $vids = $live_code_storage->revisionIds($live_code);

    $latest_revision = TRUE;

    foreach (array_reverse($vids) as $vid) {
      /** @var \Drupal\ata\LiveCodeInterface $revision */
      $revision = $live_code_storage->loadRevision($vid);
      // Only show revisions that are affected by the language that is being
      // displayed.
      if ($revision->hasTranslation($langcode) && $revision->getTranslation($langcode)->isRevisionTranslationAffected()) {
        $username = [
          '#theme' => 'username',
          '#account' => $revision->getRevisionUser(),
        ];

        // Use revision link to link to revisions that are not active.
        $date = \Drupal::service('date.formatter')->format($revision->getRevisionCreationTime(), 'short');
        if ($vid != $live_code->getRevisionId()) {
          $link = $this->l($date, new Url('entity.live_code.revision', ['live_code' => $live_code->id(), 'live_code_revision' => $vid]));
        }
        else {
          $link = $live_code->link($date);
        }

        $row = [];
        $column = [
          'data' => [
            '#type' => 'inline_template',
            '#template' => '{% trans %}{{ date }} by {{ username }}{% endtrans %}{% if message %}<p class="revision-log">{{ message }}</p>{% endif %}',
            '#context' => [
              'date' => $link,
              'username' => \Drupal::service('renderer')->renderPlain($username),
              'message' => ['#markup' => $revision->getRevisionLogMessage(), '#allowed_tags' => Xss::getHtmlTagList()],
            ],
          ],
        ];
        $row[] = $column;

        if ($latest_revision) {
          $row[] = [
            'data' => [
              '#prefix' => '<em>',
              '#markup' => $this->t('Current revision'),
              '#suffix' => '</em>',
            ],
          ];
          foreach ($row as &$current) {
            $current['class'] = ['revision-current'];
          }
          $latest_revision = FALSE;
        }
        else {
          $links = [];
          if ($revert_permission) {
            $links['revert'] = [
              'title' => $this->t('Revert'),
              'url' => $has_translations ?
              Url::fromRoute('entity.live_code.translation_revert', ['live_code' => $live_code->id(), 'live_code_revision' => $vid, 'langcode' => $langcode]) :
              Url::fromRoute('entity.live_code.revision_revert', ['live_code' => $live_code->id(), 'live_code_revision' => $vid]),
            ];
          }

          if ($delete_permission) {
            $links['delete'] = [
              'title' => $this->t('Delete'),
              'url' => Url::fromRoute('entity.live_code.revision_delete', ['live_code' => $live_code->id(), 'live_code_revision' => $vid]),
            ];
          }

          $row[] = [
            'data' => [
              '#type' => 'operations',
              '#links' => $links,
            ],
          ];
        }

        $rows[] = $row;
      }
    }

    $build['live_code_revisions_table'] = [
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
    ];

    return $build;
  }

}
