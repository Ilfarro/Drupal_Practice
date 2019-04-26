<?php

/**
 * @file
 * Contains mata_pelajaran.page.inc.
 *
 * Page callback for Mata pelajaran entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Mata pelajaran templates.
 *
 * Default template: mata_pelajaran.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_mata_pelajaran(array &$variables) {
  // Fetch MataPelajaran Entity Object.
  $mata_pelajaran = $variables['elements']['#mata_pelajaran'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
