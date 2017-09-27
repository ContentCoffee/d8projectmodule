<?php

namespace Drupal\project\Controller\TaxonomyTerm;

use Drupal\project\Controller\AbstractController;
use Drupal\project\Entity\TaxonomyTerm\Category;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class CategoryController
 * @package Drupal\proejct\Controller\TaxonomyTerm
 */
class CategoryController extends AbstractController
{
  private $themePrefix = 'term/category/';

  /**
   * CategoryController constructor.
   * @param Request $request
   */
  public function __construct(
    Request $request
  ) {
    parent::__construct($request);
  }

  /**
   * @param ContainerInterface $container
   * @return static
   */
  public static function create(ContainerInterface $container)
  {
    /** @var RequestStack $requestStack */
    $requestStack = $container->get('request_stack');

    return new static(
      $requestStack->getCurrentRequest()
    );
  }

  /**
   * @param Category $category
   * @return array
   */
  public function detail(Category $category)
  {
    return [
      '#theme' => $this->themePrefix . 'detail',
      '#category' => $category
    ];
  }
}
