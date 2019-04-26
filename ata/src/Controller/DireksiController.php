<?php

namespace Drupal\ata\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Url;
use Drupal\ata\Entity\DireksiInterface;

/**
 * Class DireksiController.
 *
 *  Returns responses for Direksi routes.
 */
class DireksiController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * Displays a Direksi  revision.
   *
   * @param int $direksi_revision
   *   The Direksi  revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  public function revisionShow($direksi_revision) {
    $direksi = $this->entityManager()->getStorage('direksi')->loadRevision($direksi_revision);
    $view_builder = $this->entityManager()->getViewBuilder('direksi');

    return $view_builder->view($direksi);
  }

  /**
   * Page title callback for a Direksi  revision.
   *
   * @param int $direksi_revision
   *   The Direksi  revision ID.
   *
   * @return string
   *   The page title.
   */
  public function revisionPageTitle($direksi_revision) {
    $direksi = $this->entityManager()->getStorage('direksi')->loadRevision($direksi_revision);
    return $this->t('Revision of %title from %date', ['%title' => $direksi->label(), '%date' => format_date($direksi->getRevisionCreationTime())]);
  }

  /**
   * Generates an overview table of older revisions of a Direksi .
   *
   * @param \Drupal\ata\Entity\DireksiInterface $direksi
   *   A Direksi  object.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function revisionOverview(DireksiInterface $direksi) {
    $account = $this->currentUser();
    $langcode = $direksi->language()->getId();
    $langname = $direksi->language()->getName();
    $languages = $direksi->getTranslationLanguages();
    $has_translations = (count($languages) > 1);
    $direksi_storage = $this->entityManager()->getStorage('direksi');

    $build['#title'] = $has_translations ? $this->t('@langname revisions for %title', ['@langname' => $langname, '%title' => $direksi->label()]) : $this->t('Revisions for %title', ['%title' => $direksi->label()]);
    $header = [$this->t('Revision'), $this->t('Operations')];

    $revert_permission = (($account->hasPermission("revert all direksi revisions") || $account->hasPermission('administer direksi entities')));
    $delete_permission = (($account->hasPermission("delete all direksi revisions") || $account->hasPermission('administer direksi entities')));

    $rows = [];

    $vids = $direksi_storage->revisionIds($direksi);

    $latest_revision = TRUE;

    foreach (array_reverse($vids) as $vid) {
      /** @var \Drupal\ata\DireksiInterface $revision */
      $revision = $direksi_storage->loadRevision($vid);
      // Only show revisions that are affected by the language that is being
      // displayed.
      if ($revision->hasTranslation($langcode) && $revision->getTranslation($langcode)->isRevisionTranslationAffected()) {
        $username = [
          '#theme' => 'username',
          '#account' => $revision->getRevisionUser(),
        ];

        // Use revision link to link to revisions that are not active.
        $date = \Drupal::service('date.formatter')->format($revision->getRevisionCreationTime(), 'short');
        if ($vid != $direksi->getRevisionId()) {
          $link = $this->l($date, new Url('entity.direksi.revision', ['direksi' => $direksi->id(), 'direksi_revision' => $vid]));
        }
        else {
          $link = $direksi->link($date);
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
              Url::fromRoute('entity.direksi.translation_revert', ['direksi' => $direksi->id(), 'direksi_revision' => $vid, 'langcode' => $langcode]) :
              Url::fromRoute('entity.direksi.revision_revert', ['direksi' => $direksi->id(), 'direksi_revision' => $vid]),
            ];
          }

          if ($delete_permission) {
            $links['delete'] = [
              'title' => $this->t('Delete'),
              'url' => Url::fromRoute('entity.direksi.revision_delete', ['direksi' => $direksi->id(), 'direksi_revision' => $vid]),
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

    $build['direksi_revisions_table'] = [
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
    ];

    return $build;
  }

}
