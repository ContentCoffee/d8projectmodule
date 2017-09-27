<?php

namespace Drupal\project\Controller\Node;

use Drupal\project\Controller\AbstractController;
use Drupal\project\Entity\Node\HomePage;

/**
 * Class HomePageController
 * @package Drupal\proejct\Controller\Node
 */
class HomePageController extends AbstractController
{
  private $themePrefix = 'node/homepage/';

  /**
   * @param \Drupal\project\Entity\Node\HomePage $homepage
   *
   * @return array
   */
  public function detail(HomePage $homepage)
  {
    return [
      '#theme' => $this->themePrefix . 'detail',
      '#homepage' => $homepage
    ];
  }

  /**
   * Access Denied Page
   * @return array
   */
  public function FourZeroThree()
  {
    return [];
  }

  /**
   * 404 Not Found
   * @return array
   */
  public function FourZeroFour()
  {
    return [];
  }

  /**
   * Title for Access Denied.
   * @return string
   */
  public function FourZeroThreeTitle()
  {
    return '403 - Access Denied';
  }

  /**
   * Title for Not Found.
   * @return string
   */
  public function FourZeroFourTitle()
  {
    return '404 - Not Found';
  }

}
