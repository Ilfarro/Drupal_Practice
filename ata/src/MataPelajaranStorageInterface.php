<?php

namespace Drupal\ata;

use Drupal\Core\Entity\ContentEntityStorageInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\ata\Entity\MataPelajaranInterface;

/**
 * Defines the storage handler class for Mata pelajaran entities.
 *
 * This extends the base storage class, adding required special handling for
 * Mata pelajaran entities.
 *
 * @ingroup ata
 */
interface MataPelajaranStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of Mata pelajaran revision IDs for a specific Mata pelajaran.
   *
   * @param \Drupal\ata\Entity\MataPelajaranInterface $entity
   *   The Mata pelajaran entity.
   *
   * @return int[]
   *   Mata pelajaran revision IDs (in ascending order).
   */
  public function revisionIds(MataPelajaranInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as Mata pelajaran author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   Mata pelajaran revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

  /**
   * Counts the number of revisions in the default language.
   *
   * @param \Drupal\ata\Entity\MataPelajaranInterface $entity
   *   The Mata pelajaran entity.
   *
   * @return int
   *   The number of revisions in the default language.
   */
  public function countDefaultLanguageRevisions(MataPelajaranInterface $entity);

  /**
   * Unsets the language for all Mata pelajaran with the given language.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language object.
   */
  public function clearRevisionsLanguage(LanguageInterface $language);

}
