<?php

namespace Drupal\project\Entity\Node;

use Drupal\node\Entity\Node;
use Drupal\project\Entity\Traits\BaseModelTrait;
use Drupal\project\Entity\Traits\ContentTrait;

/**
 * Class Page
 *
 * @package Drupal\project\Entity\Node
 */
class Page extends Node {

  use ContentTrait;
  use BaseModelTrait;

}
