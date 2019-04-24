<?php

namespace Drupal\ata\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\ContentEntityInterface;

/**
 * Defines the LiveCode entity.
 *
 * @ingroup ata
 *
 * @ContentEntityType(
 *   id = "LiveCode",
 *   label = @Translation("liveCode"),
 *   base_table = "liveCode",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "name",
 *   },
 * )
 */

class LiveCode extends ContentEntityBase implements ContentEntityInterface {

  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {

    // Standard field, used as unique if primary index.
    $fields['id'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('ID'))
      ->setDescription(t('The ID of the Live Code entity.'))
      ->setReadOnly(TRUE);

    // Standard field, unique outside of the scope of the current project.
    $fields['nama_live_code'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Nama Live Code'))
      ->setDescription(t('The Nama Live Code of the LiveCode.'))
      ->setSettings(array(
        'default_value' => '',
        'max_length' => 255,
        'text_processing' => 0,
      ));

    $fields['banyak_soal'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('Banyak Soal'))
      ->setDescription(t('The Banyak Soal of the LiveCode.'));

    $fields['bobot_nilai'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('Bobot Nilai'))
      ->setDescription(t('The Bobot Nilai of the LiveCode.'));

    $fields['tanggal_pelaksanaan'] = BaseFieldDefinition::create('datetime')
      ->setLabel(t('Tanggal Pelaksanaan'))
      ->setDescription(t('The Tanggal Pelaksanaan of the LiveCode.'))
      ->setRevisionable(TRUE)
      ->setSettings([
        'datetime_type' => 'date'
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('form', [
        'type' => 'datetime_default',]);

    $fields['mata_pelajaran'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Mata Pelajaran'))
      ->setDescription(t('The Mata Pelajaran of the LiveCode.'))
      ->setSettings(array(
        'default_value' => '',
        'max_length' => 255,
        'text_processing' => 0,
      ));

    return $fields;
  }
}
?>