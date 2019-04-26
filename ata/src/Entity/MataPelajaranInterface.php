<?php

namespace Drupal\ata\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Mata pelajaran entities.
 *
 * @ingroup ata
 */
interface MataPelajaranInterface extends ContentEntityInterface, RevisionLogInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Mata pelajaran nama_pelajaran.
   *
   * @return string
   *   Nama Pelajaran of the Mata pelajaran.
   */
  public function getNamaPelajaran();

  /**
   * Sets the Mata pelajaran nama_pelajaran.
   *
   * @param string $nama_pelajaran
   *   The Mata pelajaran nama_pelajaran.
   *
   * @return \Drupal\ata\Entity\MataPelajaranInterface
   *   The called Mata pelajaran entity.
   */
  public function setNamaPelajaran($nama_pelajaran);

  /**
   * Gets the Mata pelajaran jadwal_dimulai.
   *
   * @return string
   *   Nama Pelajaran of the Mata pelajaran.
   */
  public function getJadwalDimulai();

  /**
   * Sets the Mata pelajaran jadwal_dimulai.
   *
   * @param string $jadwal_dimulai
   *   The Mata pelajaran jadwal_dimulai.
   *
   * @return \Drupal\ata\Entity\MataPelajaranInterface
   *   The called Mata pelajaran entity.
   */
  public function setJadwalDimulai($jadwal_dimulai);

  /**
   * Gets the Mata pelajaran jadwal_berakhir.
   *
   * @return string
   *   Nama Pelajaran of the Mata pelajaran.
   */
  public function getJadwalBerakhir();

  /**
   * Sets the Mata pelajaran jadwal_berakhir.
   *
   * @param string $jadwal_berakhir
   *   The Mata pelajaran jadwal_berakhir.
   *
   * @return \Drupal\ata\Entity\MataPelajaranInterface
   *   The called Mata pelajaran entity.
   */
  public function setJadwalBerakhir($jadwal_berakhir);

  /**
   * Gets the Mata pelajaran creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Mata pelajaran.
   */
  public function getCreatedTime();

  /**
   * Sets the Mata pelajaran creation timestamp.
   *
   * @param int $timestamp
   *   The Mata pelajaran creation timestamp.
   *
   * @return \Drupal\ata\Entity\MataPelajaranInterface
   *   The called Mata pelajaran entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Mata pelajaran published status indicator.
   *
   * Unpublished Mata pelajaran are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Mata pelajaran is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Mata pelajaran.
   *
   * @param bool $published
   *   TRUE to set this Mata pelajaran to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\ata\Entity\MataPelajaranInterface
   *   The called Mata pelajaran entity.
   */
  public function setPublished($published);

  /**
   * Gets the Mata pelajaran revision creation timestamp.
   *
   * @return int
   *   The UNIX timestamp of when this revision was created.
   */
  public function getRevisionCreationTime();

  /**
   * Sets the Mata pelajaran revision creation timestamp.
   *
   * @param int $timestamp
   *   The UNIX timestamp of when this revision was created.
   *
   * @return \Drupal\ata\Entity\MataPelajaranInterface
   *   The called Mata pelajaran entity.
   */
  public function setRevisionCreationTime($timestamp);

  /**
   * Gets the Mata pelajaran revision author.
   *
   * @return \Drupal\user\UserInterface
   *   The user entity for the revision author.
   */
  public function getRevisionUser();

  /**
   * Sets the Mata pelajaran revision author.
   *
   * @param int $uid
   *   The user ID of the revision author.
   *
   * @return \Drupal\ata\Entity\MataPelajaranInterface
   *   The called Mata pelajaran entity.
   */
  public function setRevisionUserId($uid);

}
