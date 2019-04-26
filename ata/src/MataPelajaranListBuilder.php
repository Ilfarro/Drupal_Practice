<?php

namespace Drupal\ata;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;

/**
 * Defines a class to build a listing of Mata pelajaran entities.
 *
 * @ingroup ata
 */
class MataPelajaranListBuilder extends EntityListBuilder {


  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Mata pelajaran ID');
    $header['name'] = $this->t('Name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\ata\Entity\MataPelajaran */
    $row['id'] = $entity->id();
    $row['name'] = Link::createFromRoute(
      $entity->label(),
      'entity.mata_pelajaran.edit_form',
      ['mata_pelajaran' => $entity->id()]
    );
    return $row + parent::buildRow($entity);
  }

}
