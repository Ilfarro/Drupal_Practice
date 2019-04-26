<?php

/**
 * @file
 * Contains mentee.page.inc.
 *
 * Page callback for Mentee entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Mentee templates.
 *
 * Default template: mentee.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_mentee(array &$variables) {
  // Fetch Mentee Entity Object.
  $mentee = $variables['elements']['#mentee'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
