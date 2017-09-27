<?php

namespace Drupal\project\Storage;

use Drupal\node\NodeStorage;

/**
 * Class ProjectNodeStorage
 *
 * @package Drupal\project\Storage
 */
class ProjectNodeStorage extends NodeStorage {
  use ProjectStorageTrait;
  protected $entityTypeBundleKey = 'type';
}
