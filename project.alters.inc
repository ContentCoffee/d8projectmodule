<?php

use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\project\Field\ComputedSearchable;
use Drupal\project\Field\RegistrationsCount;
use Drupal\project\Field\RegistrationEmails;

/**
 * Implements hook_entity_type_alter().
 *
 * @param array $entityTypes
 */
function project_entity_type_alter(array &$entityTypes)
{

  // Template for the type class.
  $ns = 'Drupal\project\Storage\Project%type%Storage';

  // If his entity has a project storage class then use that.
  foreach ($entityTypes as $type => $data) {
    $c = str_replace("%type%", _camelize($type), $ns);
    if (class_exists($c)) {
      $entityTypes[$type]->setHandlerClass('storage', $c);
    }
  }
}

/**
 * Implements hook_entity_base_field_info_alter().
 * @param $fields
 * @param EntityTypeInterface $entity_type
 * @param $bundle
 */
function project_entity_bundle_field_info_alter(&$fields, EntityTypeInterface $entity_type, $bundle)
{
  if ($entity_type->id() == 'node') {
    $fields['computed_searchable'] = BaseFieldDefinition::create('string')
      ->setName('Computed Searchable')
      ->setLabel(t('Computed Searchable'))
      ->setComputed(TRUE)
      ->setClass(ComputedSearchable::class);
  }
  if ($entity_type->id() == "project" && $bundle == 'event_registration') {
    $fields['field_registrations_count'] = BaseFieldDefinition::create('string')
      ->setName('Registrations')
      ->setLabel(t('Registrations'))
      ->setComputed(TRUE)
      ->setClass(RegistrationsCount::class);
    $fields['field_registration_emails'] = BaseFieldDefinition::create('string')
      ->setName('Emails')
      ->setLabel(t('Emails'))
      ->setComputed(TRUE)
      ->setClass(RegistrationEmails::class);
  }
}

/**
 * Add handlers for these fields in the views.
 * @param array $data
 */
function project_views_data_alter(array &$data)
{
  $data['project']['field_registrations_count'] = array(
    'title' => t('Registrations Count'),
    'group' => t('Project'),
    'field' => array(
      'title' => t('Registrations Count'),
      'help' => t('Show the number of registrations'),
      'id' => 'field_registrations_count',
    ),
  );
  $data['project']['field_registration_emails'] = array(
    'title' => t('Emails'),
    'group' => t('Project'),
    'field' => array(
      'title' => t('Emails'),
      'help' => t('Make a copy and paste button for the email list.'),
      'id' => 'field_registration_emails',
    ),
  );
}

/**
 * Implements hook_form_alter.
 * @param $form
 * @param $form_state
 * @param $form_id
 */
function project_form_alter(&$form, $form_state, $form_id)
{
  // More often than not, this generic alter is used to discover the id of a form.
  //dump($form_id);
}



/**
 * Add expport to CSV for event registrations.
 * @param \Drupal\Core\Entity\EntityInterface $entity
 * @return array
 */
function project_entity_operation(\Drupal\Core\Entity\EntityInterface $entity) {
  $operations = [];
  if ($entity->getEntityTypeId() == "project" && $entity->bundle() == "event_registration" ) {
    $operations['exporttocsv'] = [
      'title' => t('Export to CSV'),
      'url' => \Drupal\Core\Url::fromRoute('project.export.registrations', [
        'project' => $entity->id()
      ]),
      'weight' => 50,
    ];
  }

  if ($entity->getEntityTypeId() == 'node') {
    $url = \Drupal\Core\Url::fromRoute(
      'entity.node.content_overview',
      [
        'node' => $entity->id(),
        'container' => 'content'
      ]
    );

    $operations['content'] = [
      'title' => 'Content',
      'url' => $url,
      'weight' => 50,
    ];
  }
  return $operations;
}