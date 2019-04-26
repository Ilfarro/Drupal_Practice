<?php

namespace Drupal\ata;

use Drupal\Core\Entity\ContentEntityStorageInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\ata\Entity\LiveCodeInterface;

/**
 * Defines the storage handler class for Live code entities.
 *
 * This extends the base storage class, adding required special handling for
 * Live code entities.
 *
 * @ingroup ata
 */
interface LiveCodeStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of Live code revision IDs for a specific Live code.
   *
   * @param \Drupal\ata\Entity\LiveCodeInterface $entity
   *   The Live code entity.
   *
   * @return int[]
   *   Live code revision IDs (in ascending order).
   */
  public function revisionIds(LiveCodeInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as Live code author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   Live code revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

  /**
   * Counts the number of revisions in the default language.
   *
   * @param \Drupal\ata\Entity\LiveCodeInterface $entity
   *   The Live code entity.
   *
   * @return int
   *   The number of revisions in the default language.
   */
  public function countDefaultLanguageRevisions(LiveCodeInterface $entity);

  /**
   * Unsets the language for all Live code with the given language.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language object.
   */
  public function clearRevisionsLanguage(LanguageInterface $language);

}
