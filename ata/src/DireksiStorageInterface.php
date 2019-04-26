<?php

namespace Drupal\ata;

use Drupal\Core\Entity\ContentEntityStorageInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\ata\Entity\DireksiInterface;

/**
 * Defines the storage handler class for Direksi entities.
 *
 * This extends the base storage class, adding required special handling for
 * Direksi entities.
 *
 * @ingroup ata
 */
interface DireksiStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of Direksi revision IDs for a specific Direksi.
   *
   * @param \Drupal\ata\Entity\DireksiInterface $entity
   *   The Direksi entity.
   *
   * @return int[]
   *   Direksi revision IDs (in ascending order).
   */
  public function revisionIds(DireksiInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as Direksi author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   Direksi revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

  /**
   * Counts the number of revisions in the default language.
   *
   * @param \Drupal\ata\Entity\DireksiInterface $entity
   *   The Direksi entity.
   *
   * @return int
   *   The number of revisions in the default language.
   */
  public function countDefaultLanguageRevisions(DireksiInterface $entity);

  /**
   * Unsets the language for all Direksi with the given language.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language object.
   */
  public function clearRevisionsLanguage(LanguageInterface $language);

}
