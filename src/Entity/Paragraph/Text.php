<?php

namespace Drupal\project\Entity\Paragraph;

use Drupal\paragraphs\Entity\Paragraph;

/**
 * Class Text
 * @package Drupal\project\Entity\Paragraph
 */
class Text extends Paragraph
{
    public function getContent()
    {
        return $this->get('field_content')->value;
    }
}
