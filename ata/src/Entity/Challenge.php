<?php

namespace Drupal\ata\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\RevisionableContentEntityBase;
use Drupal\Core\Entity\RevisionableInterface;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\user\UserInterface;

/**
 * Defines the Challenge entity.
 *
 * @ingroup ata
 *
 * @ContentEntityType(
 *   id = "challenge",
 *   label = @Translation("Challenge"),
 *   handlers = {
 *     "storage" = "Drupal\ata\ChallengeStorage",
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\ata\ChallengeListBuilder",
 *     "views_data" = "Drupal\ata\Entity\ChallengeViewsData",
 *     "translation" = "Drupal\ata\ChallengeTranslationHandler",
 *
 *     "form" = {
 *       "default" = "Drupal\ata\Form\ChallengeForm",
 *       "add" = "Drupal\ata\Form\ChallengeForm",
 *       "edit" = "Drupal\ata\Form\ChallengeForm",
 *       "delete" = "Drupal\ata\Form\ChallengeDeleteForm",
 *     },
 *     "access" = "Drupal\ata\ChallengeAccessControlHandler",
 *     "route_provider" = {
 *       "html" = "Drupal\ata\ChallengeHtmlRouteProvider",
 *     },
 *   },
 *   base_table = "challenge",
 *   data_table = "challenge_field_data",
 *   revision_table = "challenge_revision",
 *   revision_data_table = "challenge_field_revision",
 *   translatable = TRUE,
 *   admin_permission = "administer challenge entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "revision" = "vid",
 *     "label" = "nama_challenge",
 *     "uuid" = "uuid",
 *     "uid" = "user_id",
 *     "langcode" = "langcode",
 *     "status" = "status",
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/challenge/{challenge}",
 *     "add-form" = "/admin/structure/challenge/add",
 *     "edit-form" = "/admin/structure/challenge/{challenge}/edit",
 *     "delete-form" = "/admin/structure/challenge/{challenge}/delete",
 *     "version-history" = "/admin/structure/challenge/{challenge}/revisions",
 *     "revision" = "/admin/structure/challenge/{challenge}/revisions/{challenge_revision}/view",
 *     "revision_revert" = "/admin/structure/challenge/{challenge}/revisions/{challenge_revision}/revert",
 *     "revision_delete" = "/admin/structure/challenge/{challenge}/revisions/{challenge_revision}/delete",
 *     "translation_revert" = "/admin/structure/challenge/{challenge}/revisions/{challenge_revision}/revert/{langcode}",
 *     "collection" = "/admin/structure/challenge",
 *   },
 *   field_ui_base_route = "challenge.settings"
 * )
 */
class Challenge extends RevisionableContentEntityBase implements ChallengeInterface {

  use EntityChangedTrait;

  /**
   * {@inheritdoc}
   */
  public static function preCreate(EntityStorageInterface $storage_controller, array &$values) {
    parent::preCreate($storage_controller, $values);
    $values += [
      'user_id' => \Drupal::currentUser()->id(),
    ];
  }

  /**
   * {@inheritdoc}
   */
  protected function urlRouteParameters($rel) {
    $uri_route_parameters = parent::urlRouteParameters($rel);

    if ($rel === 'revision_revert' && $this instanceof RevisionableInterface) {
      $uri_route_parameters[$this->getEntityTypeId() . '_revision'] = $this->getRevisionId();
    }
    elseif ($rel === 'revision_delete' && $this instanceof RevisionableInterface) {
      $uri_route_parameters[$this->getEntityTypeId() . '_revision'] = $this->getRevisionId();
    }

    return $uri_route_parameters;
  }

  /**
   * {@inheritdoc}
   */
  public function preSave(EntityStorageInterface $storage) {
    parent::preSave($storage);

    foreach (array_keys($this->getTranslationLanguages()) as $langcode) {
      $translation = $this->getTranslation($langcode);

      // If no owner has been set explicitly, make the anonymous user the owner.
      if (!$translation->getOwner()) {
        $translation->setOwnerId(0);
      }
    }

    // If no revision author has been set explicitly, make the challenge owner the
    // revision author.
    if (!$this->getRevisionUser()) {
      $this->setRevisionUserId($this->getOwnerId());
    }
  }

  /**
   * {@inheritdoc}
   */
  public function getNamaChallenge() {
    return $this->get('nama_challenge')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setNamaChallenge($nama_challenge) {
    $this->set('nama_challenge', $nama_challenge);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getBanyakSoal() {
    return $this->get('banyak_soal')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setBanyakSoal($banyak_soal) {
    $this->set('banyak_soal', $banyak_soal);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getBobotNilai() {
    return $this->get('bobot_nilai')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setBobotNilai($bobot_nilai) {
    $this->set('bobot_nilai', $bobot_nilai);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getMataPelajaran() {
    return $this->get('mata_pelajaran')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setMataPelajaran($mata_pelajaran) {
    $this->set('mata_pelajaran', $mata_pelajaran);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getCreatedTime() {
    return $this->get('created')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setCreatedTime($timestamp) {
    $this->set('created', $timestamp);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwner() {
    return $this->get('user_id')->entity;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwnerId() {
    return $this->get('user_id')->target_id;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwnerId($uid) {
    $this->set('user_id', $uid);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwner(UserInterface $account) {
    $this->set('user_id', $account->id());
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function isPublished() {
    return (bool) $this->getEntityKey('status');
  }

  /**
   * {@inheritdoc}
   */
  public function setPublished($published) {
    $this->set('status', $published ? TRUE : FALSE);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['user_id'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Authored by'))
      ->setDescription(t('The user ID of author of the Challenge entity.'))
      ->setRevisionable(TRUE)
      ->setSetting('target_type', 'user')
      ->setSetting('handler', 'default')
      ->setTranslatable(TRUE)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'author',
        'weight' => 0,
      ])
      ->setDisplayOptions('form', [
        'type' => 'entity_reference_autocomplete',
        'weight' => 5,
        'settings' => [
          'match_operator' => 'CONTAINS',
          'size' => '60',
          'autocomplete_type' => 'tags',
          'placeholder' => '',
        ],
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['nama_challenge'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Nama Challenge'))
      ->setDescription(t('The Nama Challenge of the Challenge.'))
      ->setRevisionable(TRUE)
      ->setSettings([
        'max_length' => 255,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -4,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);

    $fields['banyak_soal'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('Banyak Soal'))
      ->setDescription(t('The Banyak Soal of the Challenge.'))
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -4,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);

    $fields['bobot_nilai'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('Bobot Nilai'))
      ->setDescription(t('The Bobot Nilai of the Challenge.'))
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -4,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);

    $fields['mata_pelajaran'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Mata Pelajaran'))
      ->setDescription(t('The Mata Pelajaran of the Challenge.'))
      ->setRevisionable(TRUE)
      ->setSettings([
        'max_length' => 255,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -4,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);

    $fields['status'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Publishing status'))
      ->setDescription(t('A boolean indicating whether the Challenge is published.'))
      ->setRevisionable(TRUE)
      ->setDefaultValue(TRUE)
      ->setDisplayOptions('form', [
        'type' => 'boolean_checkbox',
        'weight' => -3,
      ]);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    $fields['revision_translation_affected'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Revision translation affected'))
      ->setDescription(t('Indicates if the last edit of a translation belongs to current revision.'))
      ->setReadOnly(TRUE)
      ->setRevisionable(TRUE)
      ->setTranslatable(TRUE);

    return $fields;
  }

}
