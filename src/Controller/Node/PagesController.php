<?php

namespace Drupal\project\Controller\Node;

use Drupal\project\Controller\AbstractController;
use Drupal\project\Entity\Node\Pages;
use Drupal\project\Repository\PageRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class PagesController
 *
 * @package Drupal\proejct\Controller\Node
 */
class PagesController extends AbstractController {

  private $themePrefix = 'node/pages/';

  /** @var PageRepository */
  protected $pageRepository;

  /**
   * PageController constructor.
   *
   * @param Request $request
   * @param PageRepository $pageRepository
   */
  public function __construct(
    Request $request,
    PageRepository $pageRepository
  ) {
    parent::__construct($request);
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

    return new static(
      $requestStack->getCurrentRequest(),
      $pageRepository
    );
  }

  /**
   * @param \Drupal\project\Entity\Node\Pages $pages
   *
   * @return array
   */
  public function detail(Pages $pages) {
    $params = [];
    $params['page'] = $this->request->get('p') ? $this->request->get('p') : 1;

    $qs = $this->request->query->all();
    unset($qs['p']);
    $qs = http_build_query($qs);

    $results = $this->pageRepository->search($params);
    $results['queryString'] = $qs ? "&" . $qs : '';

    return [
      '#theme' => $this->themePrefix . 'detail',
      '#pages' => $pages,
      '#data' => [
        'results' => $results
      ]
    ];
  }
}
