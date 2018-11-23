<?php

namespace Drupal\project\Entity\Traits;

/**
 * Class BaseModelTrait
 * @package Drupal\project\Entity\Traits
 */
trait BaseModelTrait
{
  /**
   * Get the relative url to this thing.
   * @return mixed
   */
  public function getUrl()
  {

    return $this->url();
  }

  /**
   * Return the url for this.
   * @return mixed
   */
  public function getAbsoluteUrl()
  {
    return $this->url('canonical', ['absolute' => true]);
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
}