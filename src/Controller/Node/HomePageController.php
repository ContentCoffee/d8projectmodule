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
      '#homepage' => $homepage,
      '#data' => [

      ],
    ];
  }

  /**
   * Access Denied Page
   * @return array
   */
  public function FourZeroThree()
  {
    return [
      '#theme' => 'fourzerothree',
      '#data' => []
    ];
  }

  /**
   * 404 Not Found
   * @return array
   */
  public function FourZeroFour()
  {
    return [
      '#theme' => 'fourzerofour',
      '#data' => []
    ];
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
