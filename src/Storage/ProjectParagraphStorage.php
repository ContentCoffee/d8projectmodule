<?php

namespace Drupal\project\Storage;

use Drupal\Core\Entity\Sql\SqlContentEntityStorage;

/**
 * Class ProjectParagraphStorage
 *
 * @package Drupal\project\EntityTypeClass
 */
class ProjectParagraphStorage extends SqlContentEntityStorage {
  use ProjectStorageTrait;
  protected $entityTypeBundleKey = 'type';
}
