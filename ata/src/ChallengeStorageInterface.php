<?php

namespace Drupal\ata;

use Drupal\Core\Entity\ContentEntityStorageInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\ata\Entity\ChallengeInterface;

/**
 * Defines the storage handler class for Challenge entities.
 *
 * This extends the base storage class, adding required special handling for
 * Challenge entities.
 *
 * @ingroup ata
 */
interface ChallengeStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of Challenge revision IDs for a specific Challenge.
   *
   * @param \Drupal\ata\Entity\ChallengeInterface $entity
   *   The Challenge entity.
   *
   * @return int[]
   *   Challenge revision IDs (in ascending order).
   */
  public function revisionIds(ChallengeInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as Challenge author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   Challenge revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

  /**
   * Counts the number of revisions in the default language.
   *
   * @param \Drupal\ata\Entity\ChallengeInterface $entity
   *   The Challenge entity.
   *
   * @return int
   *   The number of revisions in the default language.
   */
  public function countDefaultLanguageRevisions(ChallengeInterface $entity);

  /**
   * Unsets the language for all Challenge with the given language.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language object.
   */
  public function clearRevisionsLanguage(LanguageInterface $language);

}
