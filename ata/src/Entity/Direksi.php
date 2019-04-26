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
 * Defines the Direksi entity.
 *
 * @ingroup ata
 *
 * @ContentEntityType(
 *   id = "direksi",
 *   label = @Translation("Direksi"),
 *   handlers = {
 *     "storage" = "Drupal\ata\DireksiStorage",
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\ata\DireksiListBuilder",
 *     "views_data" = "Drupal\ata\Entity\DireksiViewsData",
 *     "translation" = "Drupal\ata\DireksiTranslationHandler",
 *
 *     "form" = {
 *       "default" = "Drupal\ata\Form\DireksiForm",
 *       "add" = "Drupal\ata\Form\DireksiForm",
 *       "edit" = "Drupal\ata\Form\DireksiForm",
 *       "delete" = "Drupal\ata\Form\DireksiDeleteForm",
 *     },
 *     "access" = "Drupal\ata\DireksiAccessControlHandler",
 *     "route_provider" = {
 *       "html" = "Drupal\ata\DireksiHtmlRouteProvider",
 *     },
 *   },
 *   base_table = "direksi",
 *   data_table = "direksi_field_data",
 *   revision_table = "direksi_revision",
 *   revision_data_table = "direksi_field_revision",
 *   translatable = TRUE,
 *   admin_permission = "administer direksi entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "revision" = "vid",
 *     "label" = "nama_lengkap",
 *     "uuid" = "uuid",
 *     "uid" = "user_id",
 *     "langcode" = "langcode",
 *     "status" = "status",
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/direksi/{direksi}",
 *     "add-form" = "/admin/structure/direksi/add",
 *     "edit-form" = "/admin/structure/direksi/{direksi}/edit",
 *     "delete-form" = "/admin/structure/direksi/{direksi}/delete",
 *     "version-history" = "/admin/structure/direksi/{direksi}/revisions",
 *     "revision" = "/admin/structure/direksi/{direksi}/revisions/{direksi_revision}/view",
 *     "revision_revert" = "/admin/structure/direksi/{direksi}/revisions/{direksi_revision}/revert",
 *     "revision_delete" = "/admin/structure/direksi/{direksi}/revisions/{direksi_revision}/delete",
 *     "translation_revert" = "/admin/structure/direksi/{direksi}/revisions/{direksi_revision}/revert/{langcode}",
 *     "collection" = "/admin/structure/direksi",
 *   },
 *   field_ui_base_route = "direksi.settings"
 * )
 */
class Direksi extends RevisionableContentEntityBase implements DireksiInterface {

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

    // If no revision author has been set explicitly, make the direksi owner the
    // revision author.
    if (!$this->getRevisionUser()) {
      $this->setRevisionUserId($this->getOwnerId());
    }
  }

  /**
   * {@inheritdoc}
   */
  public function getNamaLengkap() {
    return $this->get('nama_lengkap')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setNamaLengkap($nama_lengkap) {
    $this->set('nama_lengkap', $nama_lengkap);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getTelepon() {
    return $this->get('telepon')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setTelepon($telepon) {
    $this->set('telepon', $telepon);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getJabatan() {
    return $this->get('jabatan')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setJabatan($jabatan) {
    $this->set('jabatan', $jabatan);
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
      ->setDescription(t('The user ID of author of the Direksi entity.'))
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

    $fields['nama_lengkap'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Nama Lengkap'))
      ->setDescription(t('The Nama Lengkap of the Direksi.'))
      ->setRevisionable(TRUE)
      ->setSettings([
        'max_length' => 50,
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

      $fields['telepon'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Telepon'))
      ->setDescription(t('The telepon of the Direksi.'))
      ->setRevisionable(TRUE)
      ->setSettings(array(
        'max_length' => 50,
        'text_processing' => 0,
      ))
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

    $fields['jabatan'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Jabatan'))
      ->setDescription(t('The jabatan of the Direksi.'))
      ->setRevisionable(TRUE)
      ->setSettings(array(
        'max_length' => 50,
        'text_processing' => 0,
      ))
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
      ->setDescription(t('A boolean indicating whether the Direksi is published.'))
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
