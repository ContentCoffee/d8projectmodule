<?php

namespace Drupal\project\Controller\Node;

use Drupal\project\Controller\AbstractController;
use Drupal\project\Entity\Node\Page;
use Drupal\project\Repository\PageRepository;
use Drupal\settings\Service\Settings;
use Drupal\singles\Service\Singles;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class PageController
 *
 * @package Drupal\proejct\Controller\Node
 */
class PageController extends AbstractController {

  private $themePrefix = 'node/page/';

  /** @var PageRepository */
  protected $pageRepository;

  /**
   * PageController constructor.
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   * @param \Drupal\singles\Service\Singles $singles
   * @param \Drupal\settings\Service\Settings $settings
   * @param \Drupal\project\Repository\PageRepository $pageRepository
   */
  public function __construct(
    Request $request,
    Singles $singles,
    Settings $settings,
    PageRepository $pageRepository
  ) {
    parent::__construct($request, $singles, $settings);
    $this->pageRepository = $pageRepository;
  }

  /**
   * @param ContainerInterface $container
   *
   * @return static
   */
  public static function create(ContainerInterface $container) {
    /** @var PageRepository $pageRepository */
    $pageRepository = $container->get('project.page.repository');
    /** @var RequestStack $requestStack */
    $requestStack = $container->get('request_stack');
    /** @var Singles $singles */
    $singles = $container->get('singles');
    /** @var Settings $settings */
    $settings = $container->get('settings.settings');

    return new static(
      $requestStack->getCurrentRequest(),
      $singles,
      $settings,
      $pageRepository
    );
  }

  /**
   * @param Page $page
   *
   * @return array
   */
  public function detail(Page $page) {

    return [
      '#theme' => $this->themePrefix . 'detail',
      '#page' => $page,
      '#data' => [

      ],
    ];
  }
}
