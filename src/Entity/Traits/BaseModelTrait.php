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
}