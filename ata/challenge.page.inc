<?php

/**
 * @file
 * Contains challenge.page.inc.
 *
 * Page callback for Challenge entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Challenge templates.
 *
 * Default template: challenge.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_challenge(array &$variables) {
  // Fetch Challenge Entity Object.
  $challenge = $variables['elements']['#challenge'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
