<?php

namespace Drupal\project\Entity\Node;

use Drupal\node\Entity\Node;

/**
 * Class Page
 *
 * @package Drupal\project\Entity\Node
 */
class Page extends Node {

  /**
   * @return mixed
   */
  public function getImage() {
    return $this->get('field_image')->entity;
  }

  /**
   * @return mixed
   */
  public function getContent() {
    return $this->get('field_content')->referencedEntities();
  }

  /**
   * @return \Drupal\Core\GeneratedUrl|string
   */
  public function getUrl() {
    return $this->url();
  }

  /**
   * @return string
   */
  public function getHelloWorld() {
    return "TAKE OFF!";
  }
}
