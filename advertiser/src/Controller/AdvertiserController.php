<?php

namespace Drupal\advertiser\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Defines AdvertiserController class.
 */
class AdvertiserController extends ControllerBase {

  /**
   * Display the markup.
   *
   * @return array
   *   Return markup array.
   */
  public function content() {
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Hello, Advertiser!'),
    ];
  }

}