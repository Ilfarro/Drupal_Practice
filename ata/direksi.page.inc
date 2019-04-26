<?php

/**
 * @file
 * Contains direksi.page.inc.
 *
 * Page callback for Direksi entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Direksi templates.
 *
 * Default template: direksi.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_direksi(array &$variables) {
  // Fetch Direksi Entity Object.
  $direksi = $variables['elements']['#direksi'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
