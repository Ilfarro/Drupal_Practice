<?php

namespace Drupal\ata\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Mentee entities.
 *
 * @ingroup ata
 */
interface MenteeInterface extends ContentEntityInterface, RevisionLogInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Mentee nama_lengkap.
   *
   * @return string
   *   Nama Lengkap of the Mentee.
   */
  public function getNamaLengkap();

  /**
   * Sets the Mentee nama_lengkap.
   *
   * @param string $nama_lengkap
   *   The Mentee nama_lengkap.
   *
   * @return \Drupal\ata\Entity\MenteeInterface
   *   The called Mentee entity.
   */
  public function setNamaLengkap($nama_lengkap);

  /**
   * Gets the Mentee telepon.
   *
   * @return string
   *   Telepon of the Mentee.
   */
  public function getTelepon();

  /**
   * Sets the Mentee telepon.
   *
   * @param string $telepon
   *   The Mentee telepon.
   *
   * @return \Drupal\ata\Entity\MenteeInterface
   *   The called Mentee entity.
   */
  public function setTelepon($telepon);

  /**
   * Gets the Mentee absen.
   *
   * @return string
   *   Absen of the Mentee.
   */
  public function getAbsen();

  /**
   * Sets the Mentee absen.
   *
   * @param string $absen
   *   The Mentee absen.
   *
   * @return \Drupal\ata\Entity\MenteeInterface
   *   The called Mentee entity.
   */
  public function setAbsen($absen);

  /**
   * Gets the Mentee nilai_rata2.
   *
   * @return string
   *   Nilai Rata-rata of the Mentee.
   */
  public function getNilaiRata2();

  /**
   * Sets the Mentee nilai_rata2.
   *
   * @param string $nilai_rata2
   *   The Mentee nilai_rata2.
   *
   * @return \Drupal\ata\Entity\MenteeInterface
   *   The called Mentee entity.
   */
  public function setNilaiRata2($nilai_rata2);

  /**
   * Gets the Mentee creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Mentee.
   */
  public function getCreatedTime();

  /**
   * Sets the Mentee creation timestamp.
   *
   * @param int $timestamp
   *   The Mentee creation timestamp.
   *
   * @return \Drupal\ata\Entity\MenteeInterface
   *   The called Mentee entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Mentee published status indicator.
   *
   * Unpublished Mentee are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Mentee is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Mentee.
   *
   * @param bool $published
   *   TRUE to set this Mentee to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\ata\Entity\MenteeInterface
   *   The called Mentee entity.
   */
  public function setPublished($published);

  /**
   * Gets the Mentee revision creation timestamp.
   *
   * @return int
   *   The UNIX timestamp of when this revision was created.
   */
  public function getRevisionCreationTime();

  /**
   * Sets the Mentee revision creation timestamp.
   *
   * @param int $timestamp
   *   The UNIX timestamp of when this revision was created.
   *
   * @return \Drupal\ata\Entity\MenteeInterface
   *   The called Mentee entity.
   */
  public function setRevisionCreationTime($timestamp);

  /**
   * Gets the Mentee revision author.
   *
   * @return \Drupal\user\UserInterface
   *   The user entity for the revision author.
   */
  public function getRevisionUser();

  /**
   * Sets the Mentee revision author.
   *
   * @param int $uid
   *   The user ID of the revision author.
   *
   * @return \Drupal\ata\Entity\MenteeInterface
   *   The called Mentee entity.
   */
  public function setRevisionUserId($uid);

}
