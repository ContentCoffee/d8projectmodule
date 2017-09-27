<?php

namespace Drupal\project\Storage;

use Drupal\taxonomy\TermStorage;

/**
 * Class ProjectTaxonomyTermStorage
 *
 * @package Drupal\project\Storage
 */
class ProjectTaxonomyTermStorage extends TermStorage {
  use ProjectStorageTrait;
  protected $entityTypeBundleKey = 'vid';
}
