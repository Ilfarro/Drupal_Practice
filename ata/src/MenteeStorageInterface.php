<?php

namespace Drupal\ata;

use Drupal\Core\Entity\ContentEntityStorageInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\ata\Entity\MenteeInterface;

/**
 * Defines the storage handler class for Mentee entities.
 *
 * This extends the base storage class, adding required special handling for
 * Mentee entities.
 *
 * @ingroup ata
 */
interface MenteeStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of Mentee revision IDs for a specific Mentee.
   *
   * @param \Drupal\ata\Entity\MenteeInterface $entity
   *   The Mentee entity.
   *
   * @return int[]
   *   Mentee revision IDs (in ascending order).
   */
  public function revisionIds(MenteeInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as Mentee author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   Mentee revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

  /**
   * Counts the number of revisions in the default language.
   *
   * @param \Drupal\ata\Entity\MenteeInterface $entity
   *   The Mentee entity.
   *
   * @return int
   *   The number of revisions in the default language.
   */
  public function countDefaultLanguageRevisions(MenteeInterface $entity);

  /**
   * Unsets the language for all Mentee with the given language.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language object.
   */
  public function clearRevisionsLanguage(LanguageInterface $language);

}
