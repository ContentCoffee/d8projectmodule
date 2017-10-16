<?php

namespace Drupal\project\Entity\Brick;

use Drupal\eck\Entity\EckEntity;

/**
 * Class Image
 *
 * @package Drupal\project\Entity\Brick
 */
class Image extends EckEntity {

  public function label() {
    kint($this->getImage());
    return 'image';
  }


  /**
   * @return \Drupal\image\Plugin\Field\FieldType\ImageItem
   */
  public function getImage() {
    /** @var \Drupal\image\Plugin\Field\FieldType\ImageItem $image */
    $image = $this->get('field_image')->first();
    return $image;
  }
}
