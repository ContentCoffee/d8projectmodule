<?php

namespace Drupal\project\Entity\TaxonomyTerm;

use Drupal\taxonomy\Entity\Term;

/**
 * Class Category
 *
 * @package Drupal\project\Entity\TaxonomyTerm
 */
class Category extends Term
{

  /**
   * @return mixed
   */
  public function getRandomText() {
    return $this->get('field_random_text')->value;
  }

}
