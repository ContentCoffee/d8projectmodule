<?php

namespace Drupal\project\Routing;

use Drupal\Core\Routing\RouteBuildEvent;
use Drupal\Core\Routing\RouteSubscriberBase;
use Drupal\project\Controller\ProjectController;
use Symfony\Component\Routing\RouteCollection;
use Drupal\Core\Routing\RoutingEvents;

/**
 * Listens to the dynamic route events.
 */
class RouteSubscriber extends RouteSubscriberBase {

  /**
   * @return mixed
   */
  public static function getSubscribedEvents()
  {
    // Default implementation (weight 0) doesn't suffice to
    // overwrite the defaults._controller of entity.taxonomy_term.canonical.
    $events[RoutingEvents::ALTER] = ['onAlterRoutes', -200];
    return $events;
  }

  /**
   * @param \Symfony\Component\Routing\RouteCollection $collection
   */
  protected function alterRoutes(RouteCollection $collection) {

    // Change the node and term route.
    $collection->get('entity.node.canonical')->setDefault('_controller', ProjectController::class . "::node");
    $collection->get('entity.taxonomy_term.canonical')->setDefault('_controller', ProjectController::class . "::term");

    // Add index routes for the node and terms?


  }
}
