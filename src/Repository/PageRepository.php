<?php

namespace Drupal\project\Repository;

use Drupal\Core\Entity\EntityTypeManager;
use Drupal\node\NodeStorage;

/**
 * Class PageRepository
 *
 * @package Drupal\project\Repository
 */
class PageRepository {

  /** @var NodeStorage */
  protected $storage;

  private $type = 'node';

  private $bundle = 'page';

  /**
   * PageRepository constructor.
   *
   * @param EntityTypeManager $entityTypeManager
   *
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
  public function __construct(EntityTypeManager $entityTypeManager) {
    $this->storage = $entityTypeManager->getStorage($this->type);
  }

  /**
   * @param array $params
   *
   * @return array|\Drupal\Core\Entity\EntityInterface[]
   */
  public function search(array $params = []) {
    if (!isset($params['page'])) {
      $params['page'] = 1;
    }

    if (!isset($params['perpage'])) {
      $params['perpage'] = 10;
    }

    $params['page'] = intval($params['page']);
    $params['perpage'] = intval($params['perpage']);


    // Sanitize the page somewhat.
    if ($params['page'] < 1) {
      $params['page'] = 1;
    }
    $params['page'] = intval($params['page']);

    // Sanitize the perpage a little.
    if ($params['perpage'] < 1) {
      $params['perpage'] = 10;
    }

    // Offset the start.
    $offset = ($params['page'] - 1) * $params['perpage'];

    // Start the query.
    $query = $this->storage->getQuery()
      ->condition('type', $this->bundle)
      ->condition('status', 0, '!=');

    // Sort by date.
    $query->sort('created', 'DESC');

    // Make a counting query.
    $cq = clone($query);
    $total = $cq->count()->execute();

    // Continue with the range.
    $query->range($offset, $params['perpage']);
    // Get the ids.
    $result = $query->execute();

    return [
      'page' => $params['page'],
      'pages' => intval(ceil($total / $params['perpage'])),
      'items' => $this->storage->loadMultiple($result),
      'total' => $total,
    ];
  }

}
