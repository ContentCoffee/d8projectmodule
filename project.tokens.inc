<?php
/**
 * @file
 * Builds placeholder replacement tokens for project
 */

use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\node\Entity\NodeType;

/**
 * Implements hook_token_info().
 *
 * @return array
 */
function project_token_info() {
  $types['project_tokens'] = [
    'name' => t("Project Tokens"),
    'description' => t("Project tokens"),
  ];

  // Get all singles.
  $out = [];

  $out['facebookimage'] = [
    'name' => t('The Facbook image, either from the home page or from this page.'),
    'description' => t('The facebook image url of the node image. Either from this node or from the home page.'),
  ];

  $out['description'] = [
    'name' => t('The description, either from the home page or from this page.'),
    'description' => t('The description of the node image. Either from this node or from the home page.'),
  ];

  return [
    'types' => $types,
    'tokens' => [
      'project_tokens' => $out,
    ],
  ];
}

/**
 * Implements hook_tokens().
 *
 * @return array
 */
function project_tokens($type, $tokens, array $data = [], array $options = []) {
  $replacements = [];

  if ($type == 'project_tokens') {
    foreach ($tokens as $name => $original) {
      $split = explode(':', $name);

      // Load the content type
      $homePage = \Drupal::service('singles')->getSingleByBundle('home_page');
      $node = \Drupal::routeMatch()->getParameter('node');



      if ($node) {

        $replace = '';


        if ($split[0] == 'description') {
          $replace = $node->field_description->value ? $node->field_description->value : $homePage->field_description->value;
        }

        if ($split[0] == 'facebookimage') {
          /** @var \Drupal\file\Entity\File $image */
          $image = $node->field_image->entity ? $node->field_image->entity : $homePage->field_image->entity;
          $replace = \Drupal\image\Entity\ImageStyle::load('facebook')
            ->buildUrl($image->getFileUri());

        }

        $replacements[$original] = $replace;
      }
    }
  }

  return $replacements;
}
