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
 * Defines the Mentor entity.
 *
 * @ingroup ata
 *
 * @ContentEntityType(
 *   id = "mentor",
 *   label = @Translation("Mentor"),
 *   handlers = {
 *     "storage" = "Drupal\ata\MentorStorage",
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\ata\MentorListBuilder",
 *     "views_data" = "Drupal\ata\Entity\MentorViewsData",
 *     "translation" = "Drupal\ata\MentorTranslationHandler",
 *
 *     "form" = {
 *       "default" = "Drupal\ata\Form\MentorForm",
 *       "add" = "Drupal\ata\Form\MentorForm",
 *       "edit" = "Drupal\ata\Form\MentorForm",
 *       "delete" = "Drupal\ata\Form\MentorDeleteForm",
 *     },
 *     "access" = "Drupal\ata\MentorAccessControlHandler",
 *     "route_provider" = {
 *       "html" = "Drupal\ata\MentorHtmlRouteProvider",
 *     },
 *   },
 *   base_table = "mentor",
 *   data_table = "mentor_field_data",
 *   revision_table = "mentor_revision",
 *   revision_data_table = "mentor_field_revision",
 *   translatable = TRUE,
 *   admin_permission = "administer mentor entities",
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
 *     "canonical" = "/admin/structure/mentor/{mentor}",
 *     "add-form" = "/admin/structure/mentor/add",
 *     "edit-form" = "/admin/structure/mentor/{mentor}/edit",
 *     "delete-form" = "/admin/structure/mentor/{mentor}/delete",
 *     "version-history" = "/admin/structure/mentor/{mentor}/revisions",
 *     "revision" = "/admin/structure/mentor/{mentor}/revisions/{mentor_revision}/view",
 *     "revision_revert" = "/admin/structure/mentor/{mentor}/revisions/{mentor_revision}/revert",
 *     "revision_delete" = "/admin/structure/mentor/{mentor}/revisions/{mentor_revision}/delete",
 *     "translation_revert" = "/admin/structure/mentor/{mentor}/revisions/{mentor_revision}/revert/{langcode}",
 *     "collection" = "/admin/structure/mentor",
 *   },
 *   field_ui_base_route = "mentor.settings"
 * )
 */
class Mentor extends RevisionableContentEntityBase implements MentorInterface {

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

    // If no revision author has been set explicitly, make the mentor owner the
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
      ->setDescription(t('The user ID of author of the Mentor entity.'))
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
      ->setDescription(t('The Nama Lengkap of the Mentor.'))
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

    $fields['telepon'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Telepon'))
      ->setDescription(t('The Telepon of the Mentor.'))
      ->setRevisionable(TRUE)
      ->setSettings([
        'max_length' => 25,
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

    $fields['mata_pelajaran'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Mata Pelajaran'))
      ->setDescription(t('The Mata Pelajaran of the Mentor.'))
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
      ->setDescription(t('A boolean indicating whether the Mentor is published.'))
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
