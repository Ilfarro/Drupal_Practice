<?php

namespace Drupal\ata\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Defines AtaController class.
 */
class AtaController extends ControllerBase {

  /**
   * Display the markup.
   *
   * @return array
   *   Return markup array.
   */
  public function content() {
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Ata'),
    ];
  }

}