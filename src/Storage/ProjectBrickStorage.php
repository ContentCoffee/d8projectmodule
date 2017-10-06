<?php

namespace Drupal\project\Storage;

use Drupal\Core\Entity\Sql\SqlContentEntityStorage;

/**
 * Class ProjectBrickStorage
 *
 * @package Drupal\project\EntityTypeClass
 */
class ProjectBrickStorage extends SqlContentEntityStorage {
  use ProjectStorageTrait;
  protected $entityTypeBundleKey = 'type';
}
