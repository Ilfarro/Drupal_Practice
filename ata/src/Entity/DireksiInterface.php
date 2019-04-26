<?php

namespace Drupal\ata\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Direksi entities.
 *
 * @ingroup ata
 */
interface DireksiInterface extends ContentEntityInterface, RevisionLogInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Direksi namaLengkap.
   *
   * @return string
   *   Nama Lengkap of the Direksi.
   */
  public function getNamaLengkap();

  /**
   * Sets the Direksi namaLengkap.
   *
   * @param string $namaLengkap
   *   The Direksi namaLengkap.
   *
   * @return \Drupal\ata2\Entity\DireksiInterface
   *   The called Direksi entity.
   */
  public function setNamaLengkap($namaLengkap);

  /**
   * Gets the Direksi telepon.
   *
   * @return string
   *   Telepon of the Direksi.
   */
  public function getTelepon();

  /**
   * Sets the Direksi telepon.
   *
   * @param string $telepon
   *   The Direksi telepon.
   *
   * @return \Drupal\ata2\Entity\DireksiInterface
   *   The called Direksi entity.
   */
  public function setTelepon($telepon);

  /**
   * Gets the Direksi jabatan.
   *
   * @return string
   *   Jabatan of the Direksi.
   */
  public function getJabatan();

  /**
   * Sets the Direksi jabatan.
   *
   * @param string $jabatan
   *   The Direksi jabatan.
   *
   * @return \Drupal\ata2\Entity\DireksiInterface
   *   The called Direksi entity.
   */
  public function setJabatan($jabatan);

  /**
   * Gets the Direksi creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Direksi.
   */
  public function getCreatedTime();

  /**
   * Sets the Direksi creation timestamp.
   *
   * @param int $timestamp
   *   The Direksi creation timestamp.
   *
   * @return \Drupal\ata\Entity\DireksiInterface
   *   The called Direksi entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Direksi published status indicator.
   *
   * Unpublished Direksi are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Direksi is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Direksi.
   *
   * @param bool $published
   *   TRUE to set this Direksi to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\ata\Entity\DireksiInterface
   *   The called Direksi entity.
   */
  public function setPublished($published);

  /**
   * Gets the Direksi revision creation timestamp.
   *
   * @return int
   *   The UNIX timestamp of when this revision was created.
   */
  public function getRevisionCreationTime();

  /**
   * Sets the Direksi revision creation timestamp.
   *
   * @param int $timestamp
   *   The UNIX timestamp of when this revision was created.
   *
   * @return \Drupal\ata\Entity\DireksiInterface
   *   The called Direksi entity.
   */
  public function setRevisionCreationTime($timestamp);

  /**
   * Gets the Direksi revision author.
   *
   * @return \Drupal\user\UserInterface
   *   The user entity for the revision author.
   */
  public function getRevisionUser();

  /**
   * Sets the Direksi revision author.
   *
   * @param int $uid
   *   The user ID of the revision author.
   *
   * @return \Drupal\ata\Entity\DireksiInterface
   *   The called Direksi entity.
   */
  public function setRevisionUserId($uid);

}
