<?php

namespace Drupal\ata\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\ContentEntityInterface;

/**
 * Defines the Mentee entity.
 *
 * @ingroup ata
 *
 * @ContentEntityType(
 *   id = "Mentee",
 *   label = @Translation("mentee"),
 *   base_table = "mentee",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "name",
 *   },
 * )
 */

class Mentee extends ContentEntityBase implements ContentEntityInterface {

  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {

    // Standard field, used as unique if primary index.
    $fields['id'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('ID'))
      ->setDescription(t('The ID of the Mentee entity.'))
      ->setReadOnly(TRUE);

    // Standard field, unique outside of the scope of the current project.
    $fields['nama_lengkap'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Nama Lengkap'))
      ->setDescription(t('The name of the Mentee.'))
      ->setSettings(array(
        'default_value' => '',
        'max_length' => 255,
        'text_processing' => 0,
      ));

    $fields['telepon'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Telepon'))
      ->setDescription(t('The telepon of the Mentee.'))
      ->setSettings(array(
        'default_value' => '',
        'max_length' => 25,
        'text_processing' => 0,
      ));

    $fields['absen'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('Absen'))
      ->setDescription(t('The absen of the Mentee.'));

    $fields['nilai_rata2'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('Nilai Rata-rata'))
      ->setDescription(t('The nilai rata-rata of the Mentee.'));

    return $fields;
  }
}
?>