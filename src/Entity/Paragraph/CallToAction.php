<?php

namespace Drupal\project\Entity\Paragraph;

use Drupal\paragraphs\Entity\Paragraph;

/**
 * Class CallToAction
 * @package Drupal\project\Entity\Paragraph
 */
class CallToAction extends Paragraph
{
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
