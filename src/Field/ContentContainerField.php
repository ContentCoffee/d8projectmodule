<?php
namespace Drupal\project\Field;

use Drupal\Core\Field\FieldItemList;
use Drupal\Core\TypedData\ComputedItemListTrait;
use Drupal\Core\TypedData\DataDefinitionInterface;
use Drupal\Core\TypedData\TypedDataInterface;


/**
 * Extends core URL field functionality.
 *
 * @internal
 */
class ContentContainerField extends FieldItemList {

  use ComputedItemListTrait;

  /** @var \Drupal\jsonapi_extras\EntityToJsonApi $entityToJson */
  private $entityToJson;

  /** @var \Drupal\content\ContentManager */
  private $contentManager;

  /**
   * ContentContainerField constructor.
   *
   * @param \Drupal\Core\TypedData\DataDefinitionInterface $definition
   * @param null $name
   * @param \Drupal\Core\TypedData\TypedDataInterface|NULL $parent
   */
  public function __construct(
    DataDefinitionInterface $definition,
    $name = NULL,
    TypedDataInterface $parent = NULL
  ) {
    parent::__construct($definition, $name, $parent);
    $this->entityToJson = \Drupal::service('jsonapi_extras.entity.to_jsonapi');
    $this->contentManager = \Drupal::service('content.manager');
  }


  /**
   * Give an array of the raw image files back.
   */
  protected function computeValue() {
    if (preg_match("/^jsonapi_content_container_/", $this->getName())) {
      // Assume empty list.
      $this->list = [];

      // Container that we need.
      $container = str_replace("jsonapi_content_container_", "", $this->getName());

      // The entity/page/node.
      $entity = $this->getEntity();

      // Test if it has the method.
      $bricks = $this->contentManager->getContent($entity, $container);
      if (!empty($bricks)) {
        /**
         * @var integer $delta
         * @var \Drupal\project\Entity\Brick\Brick $brick
         */
        foreach ($bricks as $delta => $brick) {
          $this->list[] = $this->createItem($delta, $this->entityToJson->serialize($brick, $brick->jsonApiIncludes()));
        }
      }
    }
  }


}
