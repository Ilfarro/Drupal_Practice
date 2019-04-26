<?php

namespace Drupal\ata;

use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
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
class MataPelajaranStorage extends SqlContentEntityStorage implements MataPelajaranStorageInterface {

  /**
   * {@inheritdoc}
   */
  public function revisionIds(MataPelajaranInterface $entity) {
    return $this->database->query(
      'SELECT vid FROM {mata_pelajaran_revision} WHERE id=:id ORDER BY vid',
      [':id' => $entity->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function userRevisionIds(AccountInterface $account) {
    return $this->database->query(
      'SELECT vid FROM {mata_pelajaran_field_revision} WHERE uid = :uid ORDER BY vid',
      [':uid' => $account->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function countDefaultLanguageRevisions(MataPelajaranInterface $entity) {
    return $this->database->query('SELECT COUNT(*) FROM {mata_pelajaran_field_revision} WHERE id = :id AND default_langcode = 1', [':id' => $entity->id()])
      ->fetchField();
  }

  /**
   * {@inheritdoc}
   */
  public function clearRevisionsLanguage(LanguageInterface $language) {
    return $this->database->update('mata_pelajaran_revision')
      ->fields(['langcode' => LanguageInterface::LANGCODE_NOT_SPECIFIED])
      ->condition('langcode', $language->getId())
      ->execute();
  }

}
