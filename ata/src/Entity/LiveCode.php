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
 * Defines the Live code entity.
 *
 * @ingroup ata
 *
 * @ContentEntityType(
 *   id = "live_code",
 *   label = @Translation("Live code"),
 *   handlers = {
 *     "storage" = "Drupal\ata\LiveCodeStorage",
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\ata\LiveCodeListBuilder",
 *     "views_data" = "Drupal\ata\Entity\LiveCodeViewsData",
 *     "translation" = "Drupal\ata\LiveCodeTranslationHandler",
 *
 *     "form" = {
 *       "default" = "Drupal\ata\Form\LiveCodeForm",
 *       "add" = "Drupal\ata\Form\LiveCodeForm",
 *       "edit" = "Drupal\ata\Form\LiveCodeForm",
 *       "delete" = "Drupal\ata\Form\LiveCodeDeleteForm",
 *     },
 *     "access" = "Drupal\ata\LiveCodeAccessControlHandler",
 *     "route_provider" = {
 *       "html" = "Drupal\ata\LiveCodeHtmlRouteProvider",
 *     },
 *   },
 *   base_table = "live_code",
 *   data_table = "live_code_field_data",
 *   revision_table = "live_code_revision",
 *   revision_data_table = "live_code_field_revision",
 *   translatable = TRUE,
 *   admin_permission = "administer live code entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "revision" = "vid",
 *     "label" = "nama_live_code",
 *     "uuid" = "uuid",
 *     "uid" = "user_id",
 *     "langcode" = "langcode",
 *     "status" = "status",
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/live_code/{live_code}",
 *     "add-form" = "/admin/structure/live_code/add",
 *     "edit-form" = "/admin/structure/live_code/{live_code}/edit",
 *     "delete-form" = "/admin/structure/live_code/{live_code}/delete",
 *     "version-history" = "/admin/structure/live_code/{live_code}/revisions",
 *     "revision" = "/admin/structure/live_code/{live_code}/revisions/{live_code_revision}/view",
 *     "revision_revert" = "/admin/structure/live_code/{live_code}/revisions/{live_code_revision}/revert",
 *     "revision_delete" = "/admin/structure/live_code/{live_code}/revisions/{live_code_revision}/delete",
 *     "translation_revert" = "/admin/structure/live_code/{live_code}/revisions/{live_code_revision}/revert/{langcode}",
 *     "collection" = "/admin/structure/live_code",
 *   },
 *   field_ui_base_route = "live_code.settings"
 * )
 */
class LiveCode extends RevisionableContentEntityBase implements LiveCodeInterface {

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

    // If no revision author has been set explicitly, make the live_code owner the
    // revision author.
    if (!$this->getRevisionUser()) {
      $this->setRevisionUserId($this->getOwnerId());
    }
  }

  /**
   * {@inheritdoc}
   */
  public function getNamaLiveCode() {
    return $this->get('nama_live_code')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setNamaLiveCode($nama_live_code) {
    $this->set('nama_live_code', $nama_live_code);
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
  public function getTanggalPelaksanaan() {
    return $this->get('tanggal_pelaksanaan')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setTanggalPelaksanaan($tanggal_pelaksanaan) {
    $this->set('tanggal_pelaksanaan', $tanggal_pelaksanaan);
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
      ->setDescription(t('The user ID of author of the Live code entity.'))
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

    $fields['nama_live_code'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Nama Live Code'))
      ->setDescription(t('The Nama Live Code of the Live Code.'))
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
      ->setDescription(t('The Banyak Soal of the Live Code.'))
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
      ->setDescription(t('The Bobot Nilai of the Live Code.'))
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

    $fields['tanggal_pelaksanaan'] = BaseFieldDefinition::create('datetime')
      ->setLabel(t('Tanggal Pelaksanaan'))
      ->setDescription(t('The Tanggal Pelaksanaan of the Live Code.'))
      ->setRevisionable(TRUE)
      ->setSettings([
        'datetime_type' => 'date'
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -4,
      ])
      ->setDisplayOptions('form', [
        'type' => 'datetime_default',])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);

    $fields['mata_pelajaran'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Mata Pelajaran'))
      ->setDescription(t('The Mata Pelajaran of the Live Code.'))
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
      ->setDescription(t('A boolean indicating whether the Live code is published.'))
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
