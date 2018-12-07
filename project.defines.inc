<?php

/**
 * Define the backgrounds that can be used in bricks.
 * @return array
 */
function project_brick_backgrounds() {
	return [
		'none' => t('None'),
		'gray' => t('Gray'),
		'blue' => t('Blue')
	];
}

/**
 * Define the types of nodes that are to be shown in the newsevents.
 * @return array
 */
function project_newsevents_types() {
  return [
    'post' => t("Post"),
    'article' => t("Article"),
    'event' => t("Event"),
    'feature' => t("Feature")
  ];
}

/**
 * Define the forms that can be used in registration.
 * @return array
 */
function project_event_registration_forms() {

  $pattern = drupal_get_path('module', 'project') . '/registration_forms/*.html.twig';
  $forms = glob($pattern);
  $out = [];

  foreach ($forms as $form) {
    $key = str_replace(".html.twig", "", strtolower(basename($form)));
    $label = ucwords(str_replace("_" , " ", $key));
    $out[$key] = $label;
  }

  return $out;
}