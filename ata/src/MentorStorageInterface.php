<?php

namespace Drupal\ata;

use Drupal\Core\Entity\ContentEntityStorageInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\ata\Entity\MentorInterface;

/**
 * Defines the storage handler class for Mentor entities.
 *
 * This extends the base storage class, adding required special handling for
 * Mentor entities.
 *
 * @ingroup ata
 */
interface MentorStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of Mentor revision IDs for a specific Mentor.
   *
   * @param \Drupal\ata\Entity\MentorInterface $entity
   *   The Mentor entity.
   *
   * @return int[]
   *   Mentor revision IDs (in ascending order).
   */
  public function revisionIds(MentorInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as Mentor author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   Mentor revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

  /**
   * Counts the number of revisions in the default language.
   *
   * @param \Drupal\ata\Entity\MentorInterface $entity
   *   The Mentor entity.
   *
   * @return int
   *   The number of revisions in the default language.
   */
  public function countDefaultLanguageRevisions(MentorInterface $entity);

  /**
   * Unsets the language for all Mentor with the given language.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language object.
   */
  public function clearRevisionsLanguage(LanguageInterface $language);

}
