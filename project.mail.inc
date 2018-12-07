<?php

use Drupal\Core\Render\Markup;

/**
 * Implements hook_mail().
 * @param $key
 * @param $message
 * @param $params
 * @throws \Drupal\Core\Entity\EntityMalformedException
 */
function project_mail($key, &$message, $params)
{

  $myKeys = [
    'new_unpublished_content',
    'content_has_been_published',
    'event_registration'
  ];

  $file = drupal_get_path('module', 'project') . '/email_templates/' . $key . '.html';

  // Only do things to mail if the themplate of the key is there and it's a key we manage.
  if (in_array($key, $myKeys) && file_exists($file)) {

    $options = array(
      'langcode' => $message['langcode'],
    );
    $message['from'] = \Drupal::config('system.site')->get('mail');
    $message['headers']['Content-Type'] = SWIFTMAILER_FORMAT_HTML;
    $message['format'] = 'text/html';

    // Set the subjects.
    $subjects['new_unpublished_content'] = t('New Unpublished Content Created: @title', array('@title' => isset($params['node']) ? $params['node']->title->value : ''), $options);
    $subjects['event_registration'] = t('New Event Registration: @title', array('@title' => isset($params['event']) ? $params['event']->title->value : ''), $options);
    $subjects['content_has_been_published'] = t('Your Content Has Been Published: @title', array('@title' => isset($params['node']) ? $params['node']->title->value : ''), $options);

    // Set the correct subject on the message.
    $message['subject'] = $subjects[$key];

    // Build up the body.
    $body = file_get_contents($file);

    /** @var \Drupal\node\Entity\Node $node */
    $node = isset($params['node']) ? $params['node'] : NULL;
    /** @var \Drupal\project\Entity\Node\Event $event */
    $event = isset($params['event']) ? $params['event'] : NULL;
    /** @var \Drupal\project\Entity\Pebble\Registration $registration */
    $registration = isset($params['registration']) ? $params['registration'] : NULL;

    // Build up the replacements.
    $replacements = [
      '%node_title%' => $node ? $node->title->value : '',
      '%node_bundle%' => $node ? $node->bundle() : '',
      '%user_first_name%' => $node ? $node->getOwner()->get('field_first_name')->value : '',
      '%user_last_name%' => $node ? $node->getOwner()->get('field_last_name')->value : '',
      '%user_email%' => $node ? $node->getOwner()->getEmail() : '',
      '%node_edit_url%' => $node ? $node->getAbsoluteEditUrl() : '',
      '%node_view_url%' => $node ? $node->getAbsoluteUrl() : '',
      '%event_title%' => $event ? $event->label() : '',
      '%event_registration_title%' => $event ? $event->getEventRegistration()->label() : '',
      '%registration_details%' => $registration ? $registration->getHtmlReport() : '',
    ];

    // Append the body.
    $message['body'][] = Markup::create(strtr($body, $replacements));
  }
}
