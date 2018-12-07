<?php

namespace Drupal\project\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\settings\Service\Settings;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Drupal\singles\Service\Singles;

/**
 * Class AbstractController
 *
 * @package Drupal\proejct\Controller
 */
abstract class AbstractController extends ControllerBase {

  /** @var Request */
  protected $request;

  /** @var array */
  protected $breadcrumb;

  /** @var Singles */
  protected $singles;

  /** @var Settings */
  protected $settings;


  /**
   * AbstractController constructor.
   *
   * @param Request $request
   * @param \Drupal\singles\Service\Singles $singles
   */
  public function __construct(Request $request, Singles $singles, Settings $settings) {
    $this->request = $request;

    $this->breadcrumb[] = [
      'text' => 'Home',
      'link' => $this->getUrlGenerator()->generateFromRoute('<front>'),
    ];

    $this->singles = $singles;
    $this->settings = $settings;
  }

  /**
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   *
   * @return static
   */
  public static function create(ContainerInterface $container) {
    /** @var RequestStack $requestStack */
    $requestStack = $container->get('request_stack');
    /** @var Singles $singles */
    $singles = $container->get('singles');

    /** @var Settings $settings */
    $settings = $container->get('settings.settings');
    return new static(
      $requestStack->getCurrentRequest(),
      $singles,
      $settings
    );
  }

  /**
   * Return the query string but with out a p variable.
   * @return array|string
   */
  public function rebuildQueryWithOutP() {
    // Remake the query string with out the p so pagination wont cludge.
    $queryString = $this->request->query->all();
    unset($queryString['p']);
    $queryString = http_build_query($queryString);
    $queryString = $queryString ? "&" . $queryString : '';
    return $queryString;
  }
}
