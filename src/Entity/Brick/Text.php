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

  /**
   * @return mixed
   */
  public function getContent() {
    return $this->get('field_content')->value;
  }

  /**
   * @return \Drupal\Core\Field\FieldItemListInterface|string
   */
  public function label() {
    return _truncate($this->getContent());
  }

  /**
   * @return string
   */
  public function toSearchableText() {
    return strip_tags($this->getContent());
  }
}
