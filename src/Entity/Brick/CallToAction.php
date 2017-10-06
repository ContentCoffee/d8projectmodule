<?php

namespace Drupal\project\Entity\Brick;

use Drupal\eck\Entity\EckEntity;

/**
 * Class CallToAction
 * @package Drupal\project\Entity\Brick
 */
class CallToAction extends EckEntity
{

    public function label() {
      return _truncate($this->getContent());
    }
    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->get('field_content')->value;
    }

    /**
     * @return mixed
     */
    public function getButtonAlignment()
    {
        return $this->get('field_button_alignment')->value;
    }

    /**
     * @return mixed
     */
    public function getButton()
    {
        return $this->get('field_button')->first();
    }
}
