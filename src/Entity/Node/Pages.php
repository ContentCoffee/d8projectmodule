<?php

namespace Drupal\project\Entity\Node;

use Drupal\node\Entity\Node;

/**
 * Class Pages
 *
 * @package Drupal\project\Entity\Node
 */
class Pages extends Node {

  /**
   * @return mixed
   */
  public function getContent() {
    return "The main pages page.";
  }

  /**
   * @return \Drupal\Core\GeneratedUrl|string
   */
  public function getUrl() {
    return $this->url();
  }

}
