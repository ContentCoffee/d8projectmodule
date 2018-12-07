<?php

namespace Drupal\project\Storage;

use Symfony\Component\Debug\Exception\FatalErrorException;

/**
 * Trait ProjectStorageTrait
 *
 * @package Drupal\project\Storage
 */
trait ProjectStorageTrait {

  /**
   * Returns the entity storage class per type/bundle.
   *
   * @param string $bundle
   *   The bundle.
   *
   * @return mixed
   *   The entity class.
   */
  public function getEntityStorageClass($bundle) {
    // Let's see if we got that class.
    $c = 'Drupal\\project\\Entity\\' . _camelize($this->entityTypeId) . '\\' . _camelize($bundle);
    if (!class_exists($c)) {
      drupal_set_message(
        sprintf('Class "%s" not found, create a class in your project to handle it.',
          $c)
      );
      return $this->entityClass;
    }
    return $c;
  }

  /**
   * @param array $values
   *
   * @return mixed
   * @throws \Symfony\Component\Debug\Exception\FatalErrorException
   */
  protected function doCreate(array $values) {
    if (!isset($this->entityTypeBundleKey)) {
      throw new FatalErrorException('The storage class ' . __CLASS__ . ' does not have a protected member "entityTypeBundleKey"', 0, 0, __FILE__, __LINE__);
    }
    $this->entityClass = $this->getEntityStorageClass($values[$this->entityTypeBundleKey]);
    return parent::doCreate($values);
  }

  /**
   * @param array $records
   * @param bool $loadFromRevision
   *
   * @return array
   * @throws \Symfony\Component\Debug\Exception\FatalErrorException
   */
  protected function mapFromStorageRecords(
    array $records,
    $loadFromRevision = FALSE
  ) {

    if (!isset($this->entityTypeBundleKey)) {
      throw new FatalErrorException('The storage class ' . __CLASS__ . ' does not have a protected member "entityTypeBundleKey"', 0, 0, __FILE__, __LINE__);
    }

    $storageRecords = [];
    $result = [];
    $key = $this->entityTypeBundleKey;

    foreach ($records as $id => $record) {

      // Drupal does not do a bundle for the user entity, so we hotwire it.
      if ($this->entityTypeId == 'user') {
        $storageRecords[$this->getEntityStorageClass('user')][$id] = $record;
      } else {
        $storageRecords[$this->getEntityStorageClass($record->$key)][$id] = $record;
      }
    }

    foreach ($storageRecords as $storageClass => $storageRecord) {
      $this->entityClass = $storageClass;
      $parentResult = parent::mapFromStorageRecords($storageRecord,
        $loadFromRevision);

      foreach ($parentResult as $parentId => $parentRecord) {
        $result[$parentId] = $parentRecord;
      }
    }
    return $result;
  }

}