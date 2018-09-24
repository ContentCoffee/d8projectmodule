<?php

namespace Drupal\project\Entity\Brick;

use Drupal\eck\Entity\EckEntity;
use Drupal\project\Entity\Traits\BrickTrait;

/**
 * Class Text
 *
 * @package Drupal\project\Entity\Brick
 */
class Text extends EckEntity {

  use BrickTrait;

  public function getContent() {
    return $this->get('field_content')->value;
  }

  public function label() {
    return _truncate($this->getContent());
  }
}
