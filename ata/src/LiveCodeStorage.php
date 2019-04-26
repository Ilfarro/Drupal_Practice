<?php

namespace Drupal\ata;

use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
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
class LiveCodeStorage extends SqlContentEntityStorage implements LiveCodeStorageInterface {

  /**
   * {@inheritdoc}
   */
  public function revisionIds(LiveCodeInterface $entity) {
    return $this->database->query(
      'SELECT vid FROM {live_code_revision} WHERE id=:id ORDER BY vid',
      [':id' => $entity->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function userRevisionIds(AccountInterface $account) {
    return $this->database->query(
      'SELECT vid FROM {live_code_field_revision} WHERE uid = :uid ORDER BY vid',
      [':uid' => $account->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function countDefaultLanguageRevisions(LiveCodeInterface $entity) {
    return $this->database->query('SELECT COUNT(*) FROM {live_code_field_revision} WHERE id = :id AND default_langcode = 1', [':id' => $entity->id()])
      ->fetchField();
  }

  /**
   * {@inheritdoc}
   */
  public function clearRevisionsLanguage(LanguageInterface $language) {
    return $this->database->update('live_code_revision')
      ->fields(['langcode' => LanguageInterface::LANGCODE_NOT_SPECIFIED])
      ->condition('langcode', $language->getId())
      ->execute();
  }

}
