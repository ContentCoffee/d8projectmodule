<?php

namespace Drupal\project\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class AbstractController
 * @package Drupal\proejct\Controller
 */
abstract class AbstractController extends ControllerBase
{
    /** @var Request */
    protected $request;

    /** @var array */
    protected $breadcrumb;

    /**
     * AbstractController constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;

        $this->breadcrumb[] = [
            'text' => 'Home',
            'link' => $this->getUrlGenerator()->generateFromRoute('<front>')
        ];
    }

    public static function create(ContainerInterface $container)
    {
        /** @var RequestStack $requestStack */
        $requestStack = $container->get('request_stack');
        return new static(
            $requestStack->getCurrentRequest()
        );
    }
}
