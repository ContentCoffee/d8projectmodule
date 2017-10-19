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

    $image = $this->getImage();

    $title = $image->getValue()['title'];
    $w = intval($image->getValue()['width']);
    $h = intval($image->getValue()['height']);
    $alt = $image->getValue()['alt'];

    $label = $title ? $title : $alt;
    $label = $label ? $label : 'no alt or title';

    $f = $image->entity->url();

    $f = '<br /><img src="'.$f.'" width="25" height="25" />';

    return $label . ' ('.$w.'x'.$h.')' . $f;
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
