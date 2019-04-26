<?php

namespace Drupal\ata\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Url;
use Drupal\ata\Entity\MenteeInterface;

/**
 * Class MenteeController.
 *
 *  Returns responses for Mentee routes.
 */
class MenteeController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * Displays a Mentee  revision.
   *
   * @param int $mentee_revision
   *   The Mentee  revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  public function revisionShow($mentee_revision) {
    $mentee = $this->entityManager()->getStorage('mentee')->loadRevision($mentee_revision);
    $view_builder = $this->entityManager()->getViewBuilder('mentee');

    return $view_builder->view($mentee);
  }

  /**
   * Page title callback for a Mentee  revision.
   *
   * @param int $mentee_revision
   *   The Mentee  revision ID.
   *
   * @return string
   *   The page title.
   */
  public function revisionPageTitle($mentee_revision) {
    $mentee = $this->entityManager()->getStorage('mentee')->loadRevision($mentee_revision);
    return $this->t('Revision of %title from %date', ['%title' => $mentee->label(), '%date' => format_date($mentee->getRevisionCreationTime())]);
  }

  /**
   * Generates an overview table of older revisions of a Mentee .
   *
   * @param \Drupal\ata\Entity\MenteeInterface $mentee
   *   A Mentee  object.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function revisionOverview(MenteeInterface $mentee) {
    $account = $this->currentUser();
    $langcode = $mentee->language()->getId();
    $langname = $mentee->language()->getName();
    $languages = $mentee->getTranslationLanguages();
    $has_translations = (count($languages) > 1);
    $mentee_storage = $this->entityManager()->getStorage('mentee');

    $build['#title'] = $has_translations ? $this->t('@langname revisions for %title', ['@langname' => $langname, '%title' => $mentee->label()]) : $this->t('Revisions for %title', ['%title' => $mentee->label()]);
    $header = [$this->t('Revision'), $this->t('Operations')];

    $revert_permission = (($account->hasPermission("revert all mentee revisions") || $account->hasPermission('administer mentee entities')));
    $delete_permission = (($account->hasPermission("delete all mentee revisions") || $account->hasPermission('administer mentee entities')));

    $rows = [];

    $vids = $mentee_storage->revisionIds($mentee);

    $latest_revision = TRUE;

    foreach (array_reverse($vids) as $vid) {
      /** @var \Drupal\ata\MenteeInterface $revision */
      $revision = $mentee_storage->loadRevision($vid);
      // Only show revisions that are affected by the language that is being
      // displayed.
      if ($revision->hasTranslation($langcode) && $revision->getTranslation($langcode)->isRevisionTranslationAffected()) {
        $username = [
          '#theme' => 'username',
          '#account' => $revision->getRevisionUser(),
        ];

        // Use revision link to link to revisions that are not active.
        $date = \Drupal::service('date.formatter')->format($revision->getRevisionCreationTime(), 'short');
        if ($vid != $mentee->getRevisionId()) {
          $link = $this->l($date, new Url('entity.mentee.revision', ['mentee' => $mentee->id(), 'mentee_revision' => $vid]));
        }
        else {
          $link = $mentee->link($date);
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
              Url::fromRoute('entity.mentee.translation_revert', ['mentee' => $mentee->id(), 'mentee_revision' => $vid, 'langcode' => $langcode]) :
              Url::fromRoute('entity.mentee.revision_revert', ['mentee' => $mentee->id(), 'mentee_revision' => $vid]),
            ];
          }

          if ($delete_permission) {
            $links['delete'] = [
              'title' => $this->t('Delete'),
              'url' => Url::fromRoute('entity.mentee.revision_delete', ['mentee' => $mentee->id(), 'mentee_revision' => $vid]),
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

    $build['mentee_revisions_table'] = [
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
    ];

    return $build;
  }

}
