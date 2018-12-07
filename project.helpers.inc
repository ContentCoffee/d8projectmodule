<?php

/**
 * Get the email addresses of the admins for this site.
 */
function project_administrator_emails() {

  /** @var \Drupal\user\UserStorage $user_storage */
  $user_storage = \Drupal::service('entity_type.manager')->getStorage('user');

  $ids = $user_storage->getQuery()
    ->condition('status', 1)
    ->condition('roles', 'administrator')
    ->execute();
  /** @var \Drupal\user\Entity\User[] $users */
  $users = $user_storage->loadMultiple($ids);
  $out = [];
  foreach ($users as $user) {
    $out[] = $user->getEmail();
  }
  return $out;
}

/**
 * @return array
 * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
 * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
 */
function project_tags() {
  $tags = [];
  $temp = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadTree('tags');
  foreach ($temp as $term) {
    $tags[$term->tid] = $term->name;
  }
  return $tags;
}

/**
 * Say whether an IP has done a registration in the last 60 seconds.
 * @return bool
 * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
 * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
 */
function project_ip_registration_throttled() {
  $throttle = 60;
  $throttle = date('Y-m-d\TH:i:s', time() - $throttle);
  $ip = \Drupal::request()->getClientIp();
  $result = \Drupal::entityTypeManager()->getStorage('pebble')->getQuery()
    ->condition('type', 'registration')
    ->condition('field_ip', $ip)
    ->condition('field_created', $throttle, '>=')
    ->count()
    ->execute();
  return $result > 0;
}


/**
 * This is a naughty naughty function, it will delete all content in the site that is not a single.
 * Developers some times use this to clean up a testing site.
 * @return array|int
 * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
 * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
 * @throws \Drupal\Core\Entity\EntityStorageException
 */
function project_kill_content() {
  /** @var \Drupal\singles\Service\Singles $singles */
  $singles = \Drupal::service('singles');
  $singlesResult = $singles->getAllSingles();
  $nodeBundlesNotToDelete = array_keys($singlesResult);
  $query = \Drupal::entityTypeManager()->getStorage('node')->getQuery()
    ->condition('type', $nodeBundlesNotToDelete, 'NOT IN');
  $result = $query->execute();
  foreach ($result as $nid) {
    $node = \Drupal::entityTypeManager()->getStorage('node')->load($nid);
    $node->delete();
  }
  return $result;
}

/**
 * @param $input
 * @param string $separator
 *
 * @return mixed
 */
function _camelize($input, $separator = '_') {
  return str_replace($separator, '', ucwords($input, $separator));
}

/**
 * Truncate a string
 *
 * @param $string
 * @param $limit
 * @param string $pad
 * @return string
 */
function _truncate($string, $limit = 40, $pad = "...")
{
  // Never truncate a url.
  if (filter_var($string, FILTER_VALIDATE_URL)) {
    return $string;
  }

  $string = trim(strip_tags($string));
  // return with no change if string is shorter than $limit
  if (strlen($string) <= $limit) {
    return $string;
  }

  // Return it with the pad.
  return mb_substr($string, 0, ($limit - strlen($pad))) . $pad;
}

