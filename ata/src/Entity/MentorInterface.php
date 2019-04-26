<?php

namespace Drupal\ata\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Mentor entities.
 *
 * @ingroup ata
 */
interface MentorInterface extends ContentEntityInterface, RevisionLogInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Mentor nama_lengkap.
   *
   * @return string
   *   Nama Lengkap of the Mentor.
   */
  public function getNamaLengkap();

  /**
   * Sets the Mentor nama_lengkap.
   *
   * @param string $nama_lengkap
   *   The Mentor nama_lengkap.
   *
   * @return \Drupal\ata\Entity\MentorInterface
   *   The called Mentor entity.
   */
  public function setNamaLengkap($nama_lengkap);

  /**
   * Gets the Mentor telepon.
   *
   * @return string
   *   Telepon of the Mentor.
   */
  public function getTelepon();

  /**
   * Sets the Mentor telepon.
   *
   * @param string $telepon
   *   The Mentor telepon.
   *
   * @return \Drupal\ata\Entity\MentorInterface
   *   The called Mentor entity.
   */
  public function setTelepon($telepon);

  /**
   * Gets the Mentor mata_pelajaran.
   *
   * @return string
   *   Mata Pelajaran of the Mentor.
   */
  public function getMataPelajaran();

  /**
   * Sets the Mentor mata_pelajaran.
   *
   * @param string $mata_pelajaran
   *   The Mentor mata_pelajaran.
   *
   * @return \Drupal\ata\Entity\MentorInterface
   *   The called Mentor entity.
   */
  public function setMataPelajaran($mata_pelajaran);

  /**
   * Gets the Mentor creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Mentor.
   */
  public function getCreatedTime();

  /**
   * Sets the Mentor creation timestamp.
   *
   * @param int $timestamp
   *   The Mentor creation timestamp.
   *
   * @return \Drupal\ata\Entity\MentorInterface
   *   The called Mentor entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Mentor published status indicator.
   *
   * Unpublished Mentor are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Mentor is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Mentor.
   *
   * @param bool $published
   *   TRUE to set this Mentor to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\ata\Entity\MentorInterface
   *   The called Mentor entity.
   */
  public function setPublished($published);

  /**
   * Gets the Mentor revision creation timestamp.
   *
   * @return int
   *   The UNIX timestamp of when this revision was created.
   */
  public function getRevisionCreationTime();

  /**
   * Sets the Mentor revision creation timestamp.
   *
   * @param int $timestamp
   *   The UNIX timestamp of when this revision was created.
   *
   * @return \Drupal\ata\Entity\MentorInterface
   *   The called Mentor entity.
   */
  public function setRevisionCreationTime($timestamp);

  /**
   * Gets the Mentor revision author.
   *
   * @return \Drupal\user\UserInterface
   *   The user entity for the revision author.
   */
  public function getRevisionUser();

  /**
   * Sets the Mentor revision author.
   *
   * @param int $uid
   *   The user ID of the revision author.
   *
   * @return \Drupal\ata\Entity\MentorInterface
   *   The called Mentor entity.
   */
  public function setRevisionUserId($uid);

}
