<?php

namespace Drupal\ata\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Live code entities.
 *
 * @ingroup ata
 */
interface LiveCodeInterface extends ContentEntityInterface, RevisionLogInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Live code nama_live_code.
   *
   * @return string
   *   Nama Live Code of the Live code.
   */
  public function getNamaLiveCode();

  /**
   * Sets the Live code nama_live_code.
   *
   * @param string $nama_live_code
   *   The Live code nama_live_code.
   *
   * @return \Drupal\ata\Entity\LiveCodeInterface
   *   The called Live code entity.
   */
  public function setNamaLiveCode($nama_live_code);

  /**
   * Gets the Live code banyak_soal.
   *
   * @return string
   *   Banyak Soal of the Live code.
   */
  public function getBanyakSoal();

  /**
   * Sets the Live code banyak_soal.
   *
   * @param string $banyak_soal
   *   The Live code banyak_soal.
   *
   * @return \Drupal\ata\Entity\LiveCodeInterface
   *   The called Live code entity.
   */
  public function setBanyakSoal($banyak_soal);

  /**
   * Gets the Live code bobot_nilai.
   *
   * @return string
   *   Bobot Nilai of the Live code.
   */
  public function getBobotNilai();

  /**
   * Sets the Live code bobot_nilai.
   *
   * @param string $bobot_nilai
   *   The Live code bobot_nilai.
   *
   * @return \Drupal\ata\Entity\LiveCodeInterface
   *   The called Live code entity.
   */
  public function setBobotNilai($bobot_nilai);

  /**
   * Gets the Live code tanggal_pelaksanaan.
   *
   * @return string
   *   Tanggal Pelaksanaan of the Live code.
   */
  public function getTanggalPelaksanaan();

  /**
   * Sets the Live code tanggal_pelaksanaan.
   *
   * @param string $tanggal_pelaksanaan
   *   The Live code tanggal_pelaksanaan.
   *
   * @return \Drupal\ata\Entity\LiveCodeInterface
   *   The called Live code entity.
   */
  public function setTanggalPelaksanaan($tanggal_pelaksanaan);

  /**
   * Gets the Live code mata_pelajaran.
   *
   * @return string
   *   Mata Pelajaran of the Live code.
   */
  public function getMataPelajaran();

  /**
   * Sets the Live code mata_pelajaran.
   *
   * @param string $mata_pelajaran
   *   The Live code mata_pelajaran.
   *
   * @return \Drupal\ata\Entity\LiveCodeInterface
   *   The called Live code entity.
   */
  public function setMataPelajaran($mata_pelajaran);

  /**
   * Gets the Live code creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Live code.
   */
  public function getCreatedTime();

  /**
   * Sets the Live code creation timestamp.
   *
   * @param int $timestamp
   *   The Live code creation timestamp.
   *
   * @return \Drupal\ata\Entity\LiveCodeInterface
   *   The called Live code entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Live code published status indicator.
   *
   * Unpublished Live code are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Live code is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Live code.
   *
   * @param bool $published
   *   TRUE to set this Live code to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\ata\Entity\LiveCodeInterface
   *   The called Live code entity.
   */
  public function setPublished($published);

  /**
   * Gets the Live code revision creation timestamp.
   *
   * @return int
   *   The UNIX timestamp of when this revision was created.
   */
  public function getRevisionCreationTime();

  /**
   * Sets the Live code revision creation timestamp.
   *
   * @param int $timestamp
   *   The UNIX timestamp of when this revision was created.
   *
   * @return \Drupal\ata\Entity\LiveCodeInterface
   *   The called Live code entity.
   */
  public function setRevisionCreationTime($timestamp);

  /**
   * Gets the Live code revision author.
   *
   * @return \Drupal\user\UserInterface
   *   The user entity for the revision author.
   */
  public function getRevisionUser();

  /**
   * Sets the Live code revision author.
   *
   * @param int $uid
   *   The user ID of the revision author.
   *
   * @return \Drupal\ata\Entity\LiveCodeInterface
   *   The called Live code entity.
   */
  public function setRevisionUserId($uid);

}
