<?php

namespace Drupal\project\Entity\Node;

use Drupal\node\Entity\Node;
use Drupal\project\Entity\Project\Banner;
use Drupal\project\Entity\Traits\BaseModelTrait;
use Drupal\project\Entity\Traits\ContentTrait;

/**
 * Class HomePage
 *
 * @package Drupal\project\Entity\Node
 */
class HomePage extends Node {

  use ContentTrait;
  use BaseModelTrait;

}
