<?php

namespace Drupal\ata\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\ContentEntityInterface;

/**
 * Defines the Challenge entity.
 *
 * @ingroup ata
 *
 * @ContentEntityType(
 *   id = "Challenge",
 *   label = @Translation("challenge"),
 *   base_table = "challenge",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "name",
 *   },
 * )
 */

class Challenge extends ContentEntityBase implements ContentEntityInterface {

  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {

    // Standard field, used as unique if primary index.
    $fields['id'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('ID'))
      ->setDescription(t('The ID of the Challenge entity.'))
      ->setReadOnly(TRUE);

    // Standard field, unique outside of the scope of the current project.
    $fields['nama_challenge'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Nama Challenge'))
      ->setDescription(t('The Nama Challenge of the Challenge.'))
      ->setSettings(array(
        'default_value' => '',
        'max_length' => 255,
        'text_processing' => 0,
      ));

    $fields['banyak_soal'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('Banyak Soal'))
      ->setDescription(t('The Banyak Soal of the Challenge.'));

    $fields['bobot_nilai'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('Bobot Nilai'))
      ->setDescription(t('The Bobot Nilai of the Challenge.'));

    $fields['mata_pelajaran'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Mata Pelajaran'))
      ->setDescription(t('The Mata Pelajaran of the Challenge.'))
      ->setSettings(array(
        'default_value' => '',
        'max_length' => 255,
        'text_processing' => 0,
      ));

    return $fields;
  }
}
?>