<?php

/**
 * @file
 * Contains live_code.page.inc.
 *
 * Page callback for Live code entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Live code templates.
 *
 * Default template: live_code.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_live_code(array &$variables) {
  // Fetch LiveCode Entity Object.
  $live_code = $variables['elements']['#live_code'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
