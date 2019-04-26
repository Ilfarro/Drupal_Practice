<?php

namespace Drupal\ata\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Url;
use Drupal\ata\Entity\MentorInterface;

/**
 * Class MentorController.
 *
 *  Returns responses for Mentor routes.
 */
class MentorController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * Displays a Mentor  revision.
   *
   * @param int $mentor_revision
   *   The Mentor  revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  public function revisionShow($mentor_revision) {
    $mentor = $this->entityManager()->getStorage('mentor')->loadRevision($mentor_revision);
    $view_builder = $this->entityManager()->getViewBuilder('mentor');

    return $view_builder->view($mentor);
  }

  /**
   * Page title callback for a Mentor  revision.
   *
   * @param int $mentor_revision
   *   The Mentor  revision ID.
   *
   * @return string
   *   The page title.
   */
  public function revisionPageTitle($mentor_revision) {
    $mentor = $this->entityManager()->getStorage('mentor')->loadRevision($mentor_revision);
    return $this->t('Revision of %title from %date', ['%title' => $mentor->label(), '%date' => format_date($mentor->getRevisionCreationTime())]);
  }

  /**
   * Generates an overview table of older revisions of a Mentor .
   *
   * @param \Drupal\ata\Entity\MentorInterface $mentor
   *   A Mentor  object.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function revisionOverview(MentorInterface $mentor) {
    $account = $this->currentUser();
    $langcode = $mentor->language()->getId();
    $langname = $mentor->language()->getName();
    $languages = $mentor->getTranslationLanguages();
    $has_translations = (count($languages) > 1);
    $mentor_storage = $this->entityManager()->getStorage('mentor');

    $build['#title'] = $has_translations ? $this->t('@langname revisions for %title', ['@langname' => $langname, '%title' => $mentor->label()]) : $this->t('Revisions for %title', ['%title' => $mentor->label()]);
    $header = [$this->t('Revision'), $this->t('Operations')];

    $revert_permission = (($account->hasPermission("revert all mentor revisions") || $account->hasPermission('administer mentor entities')));
    $delete_permission = (($account->hasPermission("delete all mentor revisions") || $account->hasPermission('administer mentor entities')));

    $rows = [];

    $vids = $mentor_storage->revisionIds($mentor);

    $latest_revision = TRUE;

    foreach (array_reverse($vids) as $vid) {
      /** @var \Drupal\ata\MentorInterface $revision */
      $revision = $mentor_storage->loadRevision($vid);
      // Only show revisions that are affected by the language that is being
      // displayed.
      if ($revision->hasTranslation($langcode) && $revision->getTranslation($langcode)->isRevisionTranslationAffected()) {
        $username = [
          '#theme' => 'username',
          '#account' => $revision->getRevisionUser(),
        ];

        // Use revision link to link to revisions that are not active.
        $date = \Drupal::service('date.formatter')->format($revision->getRevisionCreationTime(), 'short');
        if ($vid != $mentor->getRevisionId()) {
          $link = $this->l($date, new Url('entity.mentor.revision', ['mentor' => $mentor->id(), 'mentor_revision' => $vid]));
        }
        else {
          $link = $mentor->link($date);
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
              Url::fromRoute('entity.mentor.translation_revert', ['mentor' => $mentor->id(), 'mentor_revision' => $vid, 'langcode' => $langcode]) :
              Url::fromRoute('entity.mentor.revision_revert', ['mentor' => $mentor->id(), 'mentor_revision' => $vid]),
            ];
          }

          if ($delete_permission) {
            $links['delete'] = [
              'title' => $this->t('Delete'),
              'url' => Url::fromRoute('entity.mentor.revision_delete', ['mentor' => $mentor->id(), 'mentor_revision' => $vid]),
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

    $build['mentor_revisions_table'] = [
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
    ];

    return $build;
  }

}
