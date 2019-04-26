<?php

namespace Drupal\ata\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Url;
use Drupal\ata\Entity\ChallengeInterface;

/**
 * Class ChallengeController.
 *
 *  Returns responses for Challenge routes.
 */
class ChallengeController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * Displays a Challenge  revision.
   *
   * @param int $challenge_revision
   *   The Challenge  revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  public function revisionShow($challenge_revision) {
    $challenge = $this->entityManager()->getStorage('challenge')->loadRevision($challenge_revision);
    $view_builder = $this->entityManager()->getViewBuilder('challenge');

    return $view_builder->view($challenge);
  }

  /**
   * Page title callback for a Challenge  revision.
   *
   * @param int $challenge_revision
   *   The Challenge  revision ID.
   *
   * @return string
   *   The page title.
   */
  public function revisionPageTitle($challenge_revision) {
    $challenge = $this->entityManager()->getStorage('challenge')->loadRevision($challenge_revision);
    return $this->t('Revision of %title from %date', ['%title' => $challenge->label(), '%date' => format_date($challenge->getRevisionCreationTime())]);
  }

  /**
   * Generates an overview table of older revisions of a Challenge .
   *
   * @param \Drupal\ata\Entity\ChallengeInterface $challenge
   *   A Challenge  object.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function revisionOverview(ChallengeInterface $challenge) {
    $account = $this->currentUser();
    $langcode = $challenge->language()->getId();
    $langname = $challenge->language()->getName();
    $languages = $challenge->getTranslationLanguages();
    $has_translations = (count($languages) > 1);
    $challenge_storage = $this->entityManager()->getStorage('challenge');

    $build['#title'] = $has_translations ? $this->t('@langname revisions for %title', ['@langname' => $langname, '%title' => $challenge->label()]) : $this->t('Revisions for %title', ['%title' => $challenge->label()]);
    $header = [$this->t('Revision'), $this->t('Operations')];

    $revert_permission = (($account->hasPermission("revert all challenge revisions") || $account->hasPermission('administer challenge entities')));
    $delete_permission = (($account->hasPermission("delete all challenge revisions") || $account->hasPermission('administer challenge entities')));

    $rows = [];

    $vids = $challenge_storage->revisionIds($challenge);

    $latest_revision = TRUE;

    foreach (array_reverse($vids) as $vid) {
      /** @var \Drupal\ata\ChallengeInterface $revision */
      $revision = $challenge_storage->loadRevision($vid);
      // Only show revisions that are affected by the language that is being
      // displayed.
      if ($revision->hasTranslation($langcode) && $revision->getTranslation($langcode)->isRevisionTranslationAffected()) {
        $username = [
          '#theme' => 'username',
          '#account' => $revision->getRevisionUser(),
        ];

        // Use revision link to link to revisions that are not active.
        $date = \Drupal::service('date.formatter')->format($revision->getRevisionCreationTime(), 'short');
        if ($vid != $challenge->getRevisionId()) {
          $link = $this->l($date, new Url('entity.challenge.revision', ['challenge' => $challenge->id(), 'challenge_revision' => $vid]));
        }
        else {
          $link = $challenge->link($date);
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
              Url::fromRoute('entity.challenge.translation_revert', ['challenge' => $challenge->id(), 'challenge_revision' => $vid, 'langcode' => $langcode]) :
              Url::fromRoute('entity.challenge.revision_revert', ['challenge' => $challenge->id(), 'challenge_revision' => $vid]),
            ];
          }

          if ($delete_permission) {
            $links['delete'] = [
              'title' => $this->t('Delete'),
              'url' => Url::fromRoute('entity.challenge.revision_delete', ['challenge' => $challenge->id(), 'challenge_revision' => $vid]),
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

    $build['challenge_revisions_table'] = [
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
    ];

    return $build;
  }

}
