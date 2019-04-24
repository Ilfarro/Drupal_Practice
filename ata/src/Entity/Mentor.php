<?php

namespace Drupal\ata\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\ContentEntityInterface;

/**
 * Defines the Mentor entity.
 *
 * @ingroup ata
 *
 * @ContentEntityType(
 *   id = "Mentor",
 *   label = @Translation("mentor"),
 *   base_table = "mentor",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "name",
 *   },
 * )
 */

class Mentor extends ContentEntityBase implements ContentEntityInterface {

  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {

    // Standard field, used as unique if primary index.
    $fields['id'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('ID'))
      ->setDescription(t('The ID of the Mentor entity.'))
      ->setReadOnly(TRUE);

    // Standard field, unique outside of the scope of the current project.
    $fields['nama_lengkap'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Nama Lengkap'))
      ->setDescription(t('The name of the Mentor.'))
      ->setSettings(array(
        'default_value' => '',
        'max_length' => 255,
        'text_processing' => 0,
      ));

    $fields['telepon'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Telepon'))
      ->setDescription(t('The telepon of the Mentor.'))
      ->setSettings(array(
        'default_value' => '',
        'max_length' => 25,
        'text_processing' => 0,
      ));

    $fields['mata_pelajaran'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Mata Pelajaran'))
      ->setDescription(t('The Mata Pelajaran of the Mentor.'))
      ->setSettings(array(
        'default_value' => '',
        'max_length' => 255,
        'text_processing' => 0,
      ));

    return $fields;
  }
}
?>