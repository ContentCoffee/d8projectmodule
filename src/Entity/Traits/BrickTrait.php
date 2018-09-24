<?php

namespace Drupal\project\Entity\Traits;

trait BrickTrait
{
  /**
   * @return string|null
   */
  public function getSize()
  {
    if ($this->hasField('content_size')) {
      return $this->get('content_size')->value;
    }
    return null;
  }

  /**
   * @return string|null
   */
  public function getAlignment()
  {
    if ($this->hasField('content_alignment')) {
      return $this->get('content_alignment')->value;
    }
    return null;
  }
}