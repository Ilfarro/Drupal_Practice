<?php

namespace Drupal\ata\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\ContentEntityInterface;

/**
 * Defines the MataPelajaran entity.
 *
 * @ingroup ata
 *
 * @ContentEntityType(
 *   id = "MataPelajaran",
 *   label = @Translation("mataPelajaran"),
 *   base_table = "mataPelajaran",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "name",
 *   },
 * )
 */

class MataPelajaran extends ContentEntityBase implements ContentEntityInterface {

  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {

    // Standard field, used as unique if primary index.
    $fields['id'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('ID'))
      ->setDescription(t('The ID of the Advertiser entity.'))
      ->setReadOnly(TRUE);

    // Standard field, unique outside of the scope of the current project.
    $fields['nama_pelajaran'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Nama Pelajaran'))
      ->setDescription(t('The Nama Pelajaran of the MataPelajaran.'))
      ->setSettings(array(
        'default_value' => '',
        'max_length' => 255,
        'text_processing' => 0,
      ));

    $fields['jadwal_dimulai'] = BaseFieldDefinition::create('datetime')
      ->setLabel(t('Jadwal Dimulai'))
      ->setDescription(t('The Jadwal Dimulai of the MataPelajaran.'))
      ->setRevisionable(TRUE)
      ->setSettings([
        'datetime_type' => 'date'
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('form', [
        'type' => 'datetime_default',]);

    $fields['jadwal_berakhir'] = BaseFieldDefinition::create('datetime')
      ->setLabel(t('Jadwal Berakhir'))
      ->setDescription(t('The Jadwal Berakhir of the MataPelajaran.'))
      ->setRevisionable(TRUE)
      ->setSettings([
        'datetime_type' => 'date'
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('form', [
        'type' => 'datetime_default',]);

    return $fields;
  }
}
?>