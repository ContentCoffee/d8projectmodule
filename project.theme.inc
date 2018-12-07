<?php

/**
 * Implements hook_theme
 *
 * @param $existing
 * @param $type
 * @param $theme
 * @param $path
 *
 * @return array
 */
function project_theme($existing, $type, $theme, $path) {
  // We create a detail theme for each node and term type.
  // The theme will contain the main "thing" and a "data" variable
  // for stuffing extra stuff in if needed.
  $nt = \Drupal\node\Entity\NodeType::LoadMultiple();

  // Create a detail and index for both nodes and terms.
  foreach ($nt as $bundle => $data) {
    $simple = strtolower(_camelize($bundle));
    $out['node/' . $simple . '/detail'] = [
      'variables' => [
        $simple => NULL, // page, product, book, etc...
        'data' => NULL,
      ],
      'template' => 'node/'.$simple.'/detail',
    ];
  }

  $tt = taxonomy_vocabulary_get_names();
  foreach ($tt as $bundle => $data) {
    $simple = strtolower(_camelize($bundle));
    $out['term/' . $simple . '/detail'] = [
      'variables' => [
        $simple => NULL, // category, section, tag, etc...
        'data' => NULL,
      ],
      'template' => 'term/' . $simple . '/detail',
    ];
  }

  $out['fourzerofour'] = [
    'variables' => [
      'data' => NULL,
    ],
  ];

  $out['fourzerothree'] = [
    'variables' => [
      'data' => NULL,
    ],
  ];

  return $out;
}