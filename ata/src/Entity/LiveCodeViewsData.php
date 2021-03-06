<?php

namespace Drupal\ata\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Live code entities.
 */
class LiveCodeViewsData extends EntityViewsData {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    // Additional information for Views integration, such as table joins, can be
    // put here.

    return $data;
  }

}
