<?php

namespace Drupal\ata\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Url;
use Drupal\ata\Entity\MataPelajaranInterface;

/**
 * Class MataPelajaranController.
 *
 *  Returns responses for Mata pelajaran routes.
 */
class MataPelajaranController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * Displays a Mata pelajaran  revision.
   *
   * @param int $mata_pelajaran_revision
   *   The Mata pelajaran  revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  public function revisionShow($mata_pelajaran_revision) {
    $mata_pelajaran = $this->entityManager()->getStorage('mata_pelajaran')->loadRevision($mata_pelajaran_revision);
    $view_builder = $this->entityManager()->getViewBuilder('mata_pelajaran');

    return $view_builder->view($mata_pelajaran);
  }

  /**
   * Page title callback for a Mata pelajaran  revision.
   *
   * @param int $mata_pelajaran_revision
   *   The Mata pelajaran  revision ID.
   *
   * @return string
   *   The page title.
   */
  public function revisionPageTitle($mata_pelajaran_revision) {
    $mata_pelajaran = $this->entityManager()->getStorage('mata_pelajaran')->loadRevision($mata_pelajaran_revision);
    return $this->t('Revision of %title from %date', ['%title' => $mata_pelajaran->label(), '%date' => format_date($mata_pelajaran->getRevisionCreationTime())]);
  }

  /**
   * Generates an overview table of older revisions of a Mata pelajaran .
   *
   * @param \Drupal\ata\Entity\MataPelajaranInterface $mata_pelajaran
   *   A Mata pelajaran  object.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function revisionOverview(MataPelajaranInterface $mata_pelajaran) {
    $account = $this->currentUser();
    $langcode = $mata_pelajaran->language()->getId();
    $langname = $mata_pelajaran->language()->getName();
    $languages = $mata_pelajaran->getTranslationLanguages();
    $has_translations = (count($languages) > 1);
    $mata_pelajaran_storage = $this->entityManager()->getStorage('mata_pelajaran');

    $build['#title'] = $has_translations ? $this->t('@langname revisions for %title', ['@langname' => $langname, '%title' => $mata_pelajaran->label()]) : $this->t('Revisions for %title', ['%title' => $mata_pelajaran->label()]);
    $header = [$this->t('Revision'), $this->t('Operations')];

    $revert_permission = (($account->hasPermission("revert all mata pelajaran revisions") || $account->hasPermission('administer mata pelajaran entities')));
    $delete_permission = (($account->hasPermission("delete all mata pelajaran revisions") || $account->hasPermission('administer mata pelajaran entities')));

    $rows = [];

    $vids = $mata_pelajaran_storage->revisionIds($mata_pelajaran);

    $latest_revision = TRUE;

    foreach (array_reverse($vids) as $vid) {
      /** @var \Drupal\ata\MataPelajaranInterface $revision */
      $revision = $mata_pelajaran_storage->loadRevision($vid);
      // Only show revisions that are affected by the language that is being
      // displayed.
      if ($revision->hasTranslation($langcode) && $revision->getTranslation($langcode)->isRevisionTranslationAffected()) {
        $username = [
          '#theme' => 'username',
          '#account' => $revision->getRevisionUser(),
        ];

        // Use revision link to link to revisions that are not active.
        $date = \Drupal::service('date.formatter')->format($revision->getRevisionCreationTime(), 'short');
        if ($vid != $mata_pelajaran->getRevisionId()) {
          $link = $this->l($date, new Url('entity.mata_pelajaran.revision', ['mata_pelajaran' => $mata_pelajaran->id(), 'mata_pelajaran_revision' => $vid]));
        }
        else {
          $link = $mata_pelajaran->link($date);
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
              Url::fromRoute('entity.mata_pelajaran.translation_revert', ['mata_pelajaran' => $mata_pelajaran->id(), 'mata_pelajaran_revision' => $vid, 'langcode' => $langcode]) :
              Url::fromRoute('entity.mata_pelajaran.revision_revert', ['mata_pelajaran' => $mata_pelajaran->id(), 'mata_pelajaran_revision' => $vid]),
            ];
          }

          if ($delete_permission) {
            $links['delete'] = [
              'title' => $this->t('Delete'),
              'url' => Url::fromRoute('entity.mata_pelajaran.revision_delete', ['mata_pelajaran' => $mata_pelajaran->id(), 'mata_pelajaran_revision' => $vid]),
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

    $build['mata_pelajaran_revisions_table'] = [
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
    ];

    return $build;
  }

}
