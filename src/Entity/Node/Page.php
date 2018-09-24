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

  /**
   * @return mixed
   */
  public function getImage() {
    return $this->get('field_image');
  }

  /**
   * @return mixed
   */
  public function getDescription() {
    return $this->get('field_description')->value;
  }

  /**
   * @return \Drupal\Core\Entity\EntityInterface[]
   */
  public function getContent() {
    return $this->getContentContainer('content');
  }

  /**
   * @return string
   */
  public function getHelloWorld() {
    return "TAKE OFF!";
  }
}
