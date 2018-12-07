<?php

namespace Drupal\project\Entity\Traits;

/**
 * Class BaseModelTrait
 *
 * @package Drupal\project\Entity\Traits
 */
trait BaseModelTrait {

  /**
   * Get the relative url to this thing.
   *
   * @return mixed
   */
  public function getUrl() {
    return $this->url();
  }

  /**
   * Return the url for this.
   *
   * @return mixed
   */
  public function getAbsoluteUrl() {
    return $this->url('canonical', ['absolute' => TRUE]);
  }

  /**
   * @return mixed
   */
  public function getEditUrl() {
    return $this->url('edit-form');
  }

  /**
   * @return mixed
   */
  public function getAbsoluteEditUrl() {
    return $this->url('edit-form', ['absolute' => TRUE]);
  }

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
   * @return \Drupal\project\Entity\Project\Banner
   */
  public function getBanner() {
    return $this->get('field_banner')->entity;
  }

  /**
   * @return
   */
  public function getTag() {
    return $this->get('field_tag')->entity;
  }

  /**
   *
   */
  public function toSearchableText() {
    $out = '';
    $out .= $this->label();
    $out .= ' ' . $this->getDescription();
    $banner = $this->getBanner();
    if ($banner) {
      $out .= ' ' . $banner->toSearchableText();
    }
    $bricks = $this->getContent();
    foreach ($bricks as $brick) {
      $out .= ' ' . $brick->toSearchableText();
    }
    return $out;
  }
}
