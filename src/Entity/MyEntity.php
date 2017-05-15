<?php

namespace Drupal\ad_custom_entity\Entity;

use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\ad_custom_entity\MyEntityInterface;

/**
 * Defines the MyEntity entity.
 *
 * @ingroup ad_custom_entity
 *
 * @ContentEntityType(
 *   id = "ad_custom_entity_myentity",
 *   label = @Translation("MyEntity entity"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\ad_custom_entity\Entity\Controller\MyEntityListBuilder",
 *     "views_data" = "Drupal\views\EntityViewsData",
 *     "form" = {
 *       "add" = "Drupal\ad_custom_entity\Form\MyEntityForm",
 *       "edit" = "Drupal\ad_custom_entity\Form\MyEntityForm",
 *       "delete" = "Drupal\ad_custom_entity\Form\MyEntityDeleteForm",
 *     },
 *     "access" = "Drupal\ad_custom_entity\MyEntityAccessControlHandler",
 *   },
 *   base_table = "myentity",
 *   admin_permission = "administer myentity entity",
 *   fieldable = TRUE,
 *   entity_keys = {
 *     "id" = "mid",
 *     "label" = "title",
 *     "uuid" = "uuid",
 *     "langcode" = "langcode",
 *   },
 *   links = {
 *     "canonical" = "/myentity/{ad_custom_entity_myentity}",
 *     "edit-form" = "/myentity/{ad_custom_entity_myentity}/edit",
 *     "delete-form" = "/myentity/{ad_custom_entity_myentity}/delete",
 *     "collection" = "/myentity/list"
 *   },
 *   field_ui_base_route = "ad_custom_entity_myentity.myentity_settings",
 * )
 */
class MyEntity extends ContentEntityBase implements MyEntityInterface {

  /**
   * {@inheritdoc}
   */
  public function getChangedTime() {
    return $this->get('changed')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setChangedTime($timestamp) {
    $this->set('changed', $timestamp);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getChangedTimeAcrossTranslations()  {
    $changed = $this->getUntranslated()->getChangedTime();
    foreach ($this->getTranslationLanguages(FALSE) as $language)    {
      $translation_changed = $this->getTranslation($language->getId())->getChangedTime();
      $changed = max($translation_changed, $changed);
    }
    return $changed;
  }

  /**
   * {@inheritdoc}
   *
   * Define the field properties here.
   *
   * Field name, type and size determine the table structure.
   *
   * In addition, we can define how the field and its content can be manipulated
   * in the GUI. The behaviour of the widgets used can be determined here.
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {

    // Standard field, used as unique if primary index.
    $fields['mid'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('MID'))
      ->setDescription(t('The MID of the MyEntity entity.'))
      ->setReadOnly(TRUE);

    // Standard field, unique outside of the scope of the current project.
    $fields['uuid'] = BaseFieldDefinition::create('uuid')
      ->setLabel(t('UUID'))
      ->setDescription(t('The UUID of the MyEntity entity.'))
      ->setReadOnly(TRUE);

    $fields['title'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Name'))
      ->setDescription(t('The name of the MyEntity entity.'))
      ->setSettings(array(
        'default_value' => '',
        'max_length' => 255,
        'text_processing' => 0,
      ))
      ->setDisplayOptions('view', array(
        'label' => 'above',
        'type' => 'string',
        'weight' => 0,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'string_textfield',
        'weight' => 0,
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['description'] = BaseFieldDefinition::create('string_long')
      ->setLabel(t('Description'))
      ->setDescription(t('The description of the MyEntity entity.'))
      ->setSettings(array(
        'default_value' => '',
      ))
      ->setDisplayOptions('view', array(
        'label' => 'above',
        'type' => 'basic_string',
        'weight' => 10,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'text_textarea',
        'weight' => 10,
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['link'] = BaseFieldDefinition::create('link')
      ->setLabel(t('Description'))
      ->setDescription(t('The link of the MyEntity entity.'))
      ->setSettings(array(
        'default_value' => '',
      ))
      ->setDisplayOptions('view', array(
        'label' => 'above',
        'type' => 'link',
        'weight' => 15,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'link_default',
        'weight' => 15,
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['langcode'] = BaseFieldDefinition::create('language')
      ->setLabel(t('Language code'))
      ->setDescription(t('The language code of MyEntity entity.'));

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    return $fields;
  }
}
