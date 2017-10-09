<?php

namespace Drupal\project\Controller;

use Drupal\Core\Controller\ControllerBase;
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


  /**
   * AbstractController constructor.
   *
   * @param Request $request
   * @param \Drupal\singles\Service\Singles $singles
   */
  public function __construct(Request $request, Singles $singles) {
    $this->request = $request;

    $this->breadcrumb[] = [
      'text' => 'Home',
      'link' => $this->getUrlGenerator()->generateFromRoute('<front>'),
    ];

    $this->singles = $singles;
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
    return new static(
      $requestStack->getCurrentRequest(),
      $singles
    );
  }
}
