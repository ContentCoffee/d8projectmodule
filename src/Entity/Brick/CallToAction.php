<?php

namespace Drupal\project\Entity\Brick;

use Drupal\eck\Entity\EckEntity;

/**
 * Class CallToAction
 *
 * @package Drupal\project\Entity\Brick
 */
class CallToAction extends EckEntity {

  public function label() {
    $button = $this->getButton();
    return _truncate($this->getContent()) ? _truncate($this->getContent()) : $button->getValue()['title'];
  }

  /**
   * @return mixed
   */
  public function getContent() {
    return $this->get('field_content')->value;
  }

  /**
   * @return \Drupal\Core\TypedData\TypedDataInterface
   */
  public function getButton() {
    return $this->get('field_button')->first();
  }
}
