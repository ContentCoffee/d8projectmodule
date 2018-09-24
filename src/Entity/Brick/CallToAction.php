<?php

namespace Drupal\project\Entity\Brick;

use Drupal\eck\Entity\EckEntity;
use Drupal\project\Entity\Traits\BrickTrait;

/**
 * Class CallToAction
 *
 * @package Drupal\project\Entity\Brick
 */
class CallToAction extends EckEntity {

  use BrickTrait;

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
   * @throws \Drupal\Core\TypedData\Exception\MissingDataException
   */
  public function getButton() {
    return $this->get('field_button')->first();
  }
}
