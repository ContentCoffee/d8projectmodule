<?php

namespace Drupal\project\Controller\Node;

use Drupal\project\Controller\AbstractController;
use Drupal\project\Entity\Node\Page;
use Drupal\project\Repository\PageRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class PageController
 * @package Drupal\proejct\Controller\Node
 */
class PageController extends AbstractController
{
    private $themePrefix = 'node/page/';

    /** @var PageRepository */
    protected $pageRepository;

    /**
     * PageController constructor.
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
     * @return static
     */
    public static function create(ContainerInterface $container)
    {
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
     * @return array
     */
    public function index()
    {
        $params = [];
        $params['page'] = $this->request->get('p') ? $this->request->get('p') : 1;

        $qs = $this->request->query->all();
        unset($qs['p']);
        $qs = http_build_query($qs);

        $results = $this->pageRepository->search($params);
        $results['queryString'] = $qs ? "&" . $qs : '';

        return [
            '#theme' => $this->themePrefix . 'index',
            '#results' => $results
        ];
    }

    /**
     * @return string
     */
    public function indexTitle()
    {
        return 'Bitch Please';
    }

    /**
     * @param Page $page
     * @return array
     */
    public function detail(Page $page)
    {
        return [
            '#theme' => $this->themePrefix . 'detail',
            '#page' => $page
        ];
    }
}
