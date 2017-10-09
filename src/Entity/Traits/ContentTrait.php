<?php

namespace Drupal\project\Entity\Traits;

use Drupal\Core\Entity\EntityInterface;


trait ContentTrait
{
  /**
   * Get content of this entity.
   *
   * @param string $container
   *
   * @return EntityInterface[]|array
   */
  protected function getContentContainer($container = null)
  {
    /** @var \Drupal\content\ContentManager $manager */
    $manager = $this->contentManager();

    if ($container) {
      $containers = is_array($container) ? $container : [$container];
    } else {
      $containers = $manager->getHostContainers($this);
    }

    $entities = [];
    foreach ($containers as $name) {
      $entities[$name] = $manager->getContent($this, $name);
    }

    if ($container) {
      return $entities[$container];
    }

    return $entities;
  }

  /**
   * @return \Drupal\content\ContentManager
   */
  private function contentManager()
  {
    return \Drupal::service('content.manager');
  }

  /**
   * @return string|null
   */
  public function getSize()
  {
    if ($this->hasField('c_content_size')) {
      return $this->get('c_content_size')->value;
    }
    return null;
  }

  /**
   * @return string|null
   */
  public function getAlignment()
  {
    if ($this->hasField('c_content_alignment')) {
      return $this->get('c_content_alignment')->value;
    }
    return null;
  }

}