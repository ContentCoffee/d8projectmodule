<?php

namespace Drupal\project\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\EntityInterface;

/**
 * Class ProjectController
 * @package Drupal\proejct\Controller
 */
class ProjectController extends ControllerBase
{
  /**
   * @param EntityInterface $node
   * @return array|mixed
   */
  public function node(EntityInterface $node)
  {
    return $this->delegate($node);
  }

  /**
   * @param EntityInterface $taxonomy_term
   * @return array|mixed
   */
  public function term(EntityInterface $taxonomy_term)
  {
    return $this->delegate($taxonomy_term);
  }

  /**
   * @param EntityInterface $entity
   * @return array|mixed
   */
  public function delegate(EntityInterface $entity)
  {
    // Not sure how this could happen but in any case move on.
    if (!$entity) {
      drupal_set_message('Entity given to ProjectController::delegate was null');
      return [];
    }

    // NameSpace for project controllers.
    $ns = 'Drupal\\project\\Controller\\';

    // Type and Bundle
    $type = $entity->getEntityTypeId();
    $bundle = $entity->bundle();

    // Full Class Name, Drupal\project\Controller\Type\Bundle.
    $c = $ns . _camelize($type) . '\\' . _camelize($bundle) . 'Controller';

    // Do we have a class?
    if (!class_exists($c)) {
      drupal_set_message(
        sprintf('Class "%s" not found', $c)
      );
      return [];
    }

    // Is this class a subclass of ControllerBase?
    if (!is_subclass_of($c, ControllerBase::class)) {
      drupal_set_message(
        sprintf(
          'Class "%s" does not extend "%s"',
          $c,
          ControllerBase::class
        )
      );
      return [];
    }

    // Call the create method.
    $create = [$c, 'create'];
    // Can we create a static.
    if (!is_callable($create)) {
      drupal_set_message(
        sprintf(
          'Class "%s" does not have a create function.',
          $c
        )
      );
      return [];
    }

    // Create it and get ready to call detail.
    $controller = [call_user_func($create, \Drupal::getContainer()), 'detail'];

    // Can we run the detail function?
    if (!is_callable($controller)) {
      drupal_set_message(
        sprintf(
          'Class "%s" does not have a detail() function.',
          get_class($controller[0])
        )
      );
      return [];
    }

    // Get the output.
    $out = call_user_func($controller, $entity);

    if (is_array($out)) {
      // Invalidate the cache on node update or term update or brick update.
      $out['#cache'] = [
        'tags' => [
          'node_list',
          'taxonomy_term_list',
          'brick_list'
        ],
        'max-age' => 3600,
      ];
    }

    return $out;
  }
}
