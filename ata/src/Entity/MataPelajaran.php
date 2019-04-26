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
 * Defines the Mata pelajaran entity.
 *
 * @ingroup ata
 *
 * @ContentEntityType(
 *   id = "mata_pelajaran",
 *   label = @Translation("Mata pelajaran"),
 *   handlers = {
 *     "storage" = "Drupal\ata\MataPelajaranStorage",
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\ata\MataPelajaranListBuilder",
 *     "views_data" = "Drupal\ata\Entity\MataPelajaranViewsData",
 *     "translation" = "Drupal\ata\MataPelajaranTranslationHandler",
 *
 *     "form" = {
 *       "default" = "Drupal\ata\Form\MataPelajaranForm",
 *       "add" = "Drupal\ata\Form\MataPelajaranForm",
 *       "edit" = "Drupal\ata\Form\MataPelajaranForm",
 *       "delete" = "Drupal\ata\Form\MataPelajaranDeleteForm",
 *     },
 *     "access" = "Drupal\ata\MataPelajaranAccessControlHandler",
 *     "route_provider" = {
 *       "html" = "Drupal\ata\MataPelajaranHtmlRouteProvider",
 *     },
 *   },
 *   base_table = "mata_pelajaran",
 *   data_table = "mata_pelajaran_field_data",
 *   revision_table = "mata_pelajaran_revision",
 *   revision_data_table = "mata_pelajaran_field_revision",
 *   translatable = TRUE,
 *   admin_permission = "administer mata pelajaran entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "revision" = "vid",
 *     "label" = "nama_pelajaran",
 *     "uuid" = "uuid",
 *     "uid" = "user_id",
 *     "langcode" = "langcode",
 *     "status" = "status",
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/mata_pelajaran/{mata_pelajaran}",
 *     "add-form" = "/admin/structure/mata_pelajaran/add",
 *     "edit-form" = "/admin/structure/mata_pelajaran/{mata_pelajaran}/edit",
 *     "delete-form" = "/admin/structure/mata_pelajaran/{mata_pelajaran}/delete",
 *     "version-history" = "/admin/structure/mata_pelajaran/{mata_pelajaran}/revisions",
 *     "revision" = "/admin/structure/mata_pelajaran/{mata_pelajaran}/revisions/{mata_pelajaran_revision}/view",
 *     "revision_revert" = "/admin/structure/mata_pelajaran/{mata_pelajaran}/revisions/{mata_pelajaran_revision}/revert",
 *     "revision_delete" = "/admin/structure/mata_pelajaran/{mata_pelajaran}/revisions/{mata_pelajaran_revision}/delete",
 *     "translation_revert" = "/admin/structure/mata_pelajaran/{mata_pelajaran}/revisions/{mata_pelajaran_revision}/revert/{langcode}",
 *     "collection" = "/admin/structure/mata_pelajaran",
 *   },
 *   field_ui_base_route = "mata_pelajaran.settings"
 * )
 */
class MataPelajaran extends RevisionableContentEntityBase implements MataPelajaranInterface {

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

    // If no revision author has been set explicitly, make the mata_pelajaran owner the
    // revision author.
    if (!$this->getRevisionUser()) {
      $this->setRevisionUserId($this->getOwnerId());
    }
  }

  /**
   * {@inheritdoc}
   */
  public function getNamaPelajaran() {
    return $this->get('nama_pelajaran')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setNamaPelajaran($nama_pelajaran) {
    $this->set('nama_pelajaran', $nama_pelajaran);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getJadwalDimulai() {
    return $this->get('jadwal_dimulai')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setJadwalDimulai($jadwal_dimulai) {
    $this->set('jadwal_dimulai', $jadwal_dimulai);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getJadwalBerakhir() {
    return $this->get('jadwal_berakhir')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setJadwalBerakhir($jadwal_berakhir) {
    $this->set('jadwal_berakhir', $jadwal_berakhir);
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
      ->setDescription(t('The user ID of author of the Mata pelajaran entity.'))
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

    $fields['nama_pelajaran'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Nama Pelajaran'))
      ->setDescription(t('The Nama Pelajaran of the Mata pelajaran.'))
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

    $fields['jadwal_dimulai'] = BaseFieldDefinition::create('datetime')
      ->setLabel(t('Jadwal Dimulai'))
      ->setDescription(t('The Jadwal Dimulai of the Mata pelajaran.'))
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

    $fields['jadwal_berakhir'] = BaseFieldDefinition::create('datetime')
      ->setLabel(t('Jadwal Berakhir'))
      ->setDescription(t('The Jadwal Berakhir of the Mata pelajaran.'))
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

    $fields['status'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Publishing status'))
      ->setDescription(t('A boolean indicating whether the Mata pelajaran is published.'))
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
