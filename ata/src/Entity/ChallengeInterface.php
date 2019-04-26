<?php

namespace Drupal\ata\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Challenge entities.
 *
 * @ingroup ata
 */
interface ChallengeInterface extends ContentEntityInterface, RevisionLogInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Challenge nama_challenge.
   *
   * @return string
   *   Nama Challenge of the Challenge.
   */
  public function getNamaChallenge();

  /**
   * Sets the Challenge nama_challenge.
   *
   * @param string $nama_challenge
   *   The Challenge nama_challenge.
   *
   * @return \Drupal\ata\Entity\ChallengeInterface
   *   The called Challenge entity.
   */
  public function setNamaChallenge($nama_challenge);

  /**
   * Gets the Challenge banyak_soal.
   *
   * @return string
   *   Banyak Soal of the Challenge.
   */
  public function getBanyakSoal();

  /**
   * Sets the Challenge banyak_soal.
   *
   * @param string $banyak_soal
   *   The Challenge banyak_soal.
   *
   * @return \Drupal\ata\Entity\ChallengeInterface
   *   The called Challenge entity.
   */
  public function setBanyakSoal($banyak_soal);

  /**
   * Gets the Challenge bobot_nilai.
   *
   * @return string
   *   Bobot Nilai of the Challenge.
   */
  public function getBobotNilai();

  /**
   * Sets the Challenge bobot_nilai.
   *
   * @param string $bobot_nilai
   *   The Challenge bobot_nilai.
   *
   * @return \Drupal\ata\Entity\ChallengeInterface
   *   The called Challenge entity.
   */
  public function setBobotNilai($bobot_nilai);

  /**
   * Gets the Challenge mata_pelajaran.
   *
   * @return string
   *   Mata Pelajaran of the Challenge.
   */
  public function getMataPelajaran();

  /**
   * Sets the Challenge mata_pelajaran.
   *
   * @param string $mata_pelajaran
   *   The Challenge mata_pelajaran.
   *
   * @return \Drupal\ata\Entity\ChallengeInterface
   *   The called Challenge entity.
   */
  public function setMataPelajaran($mata_pelajaran);

  /**
   * Gets the Challenge creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Challenge.
   */
  public function getCreatedTime();

  /**
   * Sets the Challenge creation timestamp.
   *
   * @param int $timestamp
   *   The Challenge creation timestamp.
   *
   * @return \Drupal\ata\Entity\ChallengeInterface
   *   The called Challenge entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Challenge published status indicator.
   *
   * Unpublished Challenge are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Challenge is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Challenge.
   *
   * @param bool $published
   *   TRUE to set this Challenge to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\ata\Entity\ChallengeInterface
   *   The called Challenge entity.
   */
  public function setPublished($published);

  /**
   * Gets the Challenge revision creation timestamp.
   *
   * @return int
   *   The UNIX timestamp of when this revision was created.
   */
  public function getRevisionCreationTime();

  /**
   * Sets the Challenge revision creation timestamp.
   *
   * @param int $timestamp
   *   The UNIX timestamp of when this revision was created.
   *
   * @return \Drupal\ata\Entity\ChallengeInterface
   *   The called Challenge entity.
   */
  public function setRevisionCreationTime($timestamp);

  /**
   * Gets the Challenge revision author.
   *
   * @return \Drupal\user\UserInterface
   *   The user entity for the revision author.
   */
  public function getRevisionUser();

  /**
   * Sets the Challenge revision author.
   *
   * @param int $uid
   *   The user ID of the revision author.
   *
   * @return \Drupal\ata\Entity\ChallengeInterface
   *   The called Challenge entity.
   */
  public function setRevisionUserId($uid);

}
