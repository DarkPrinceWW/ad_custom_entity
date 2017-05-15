<?php

namespace Drupal\ad_custom_entity\Entity\Controller;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;
use Drupal\Core\Url;

/**
 * Provides a list controller for ad_custom_entity_myentity entity.
 *
 * @ingroup ad_custom_entity
 */
class MyEntityListBuilder extends EntityListBuilder {

  /**
   * {@inheritdoc}
   *
   * We override ::render() so that we can add our own content above the table.
   * parent::render() is where EntityListBuilder creates the table using our
   * buildHeader() and buildRow() implementations.
   */
  public function render() {
    $build['description'] = [
      '#markup' => $this->t('AD Custom Entity implements a MyEntity model. These myentities are fieldable entities. You can manage the fields on the <a href="@adminlink">AD Custom Entity</a>.', array(
        '@adminlink' => \Drupal::urlGenerator()
          ->generateFromRoute('ad_custom_entity_myentity.myentity_settings'),
      )),
    ];

    $build += parent::render();
    return $build;
  }

  /**
   * {@inheritdoc}
   *
   * Building the header and content lines for the myentity list.
   *
   * Calling the parent::buildHeader() adds a column for the possible actions
   * and inserts the 'edit' and 'delete' links as defined for the entity type.
   */
  public function buildHeader() {
    $header['id'] = $this->t('MID');
    $header['title'] = $this->t('Title');
    $header['description'] = $this->t('Description');
    $header['link'] = $this->t('Link');
    $header['language'] = $this->t('Language');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\ad_custom_entity\Entity\MyEntity */
    $row['id'] = $entity->id();
    $row['title'] = $entity->link();
    $row['description'] = $entity->description->value;

    $link_value = $entity->link->getValue();
    $link = '';
    if (!empty($link_value)) {
      $link_title = !empty($link_value[0]['title']) ? $link_value[0]['title'] : $link_value[0]['uri'];
      $link_url = Url::fromUri($link_value[0]['uri']);
      $link = Link::fromTextAndUrl($link_title, $link_url);
    }

    $row['link'] = $link;
    $row['language'] = $entity->langcode->value;
    return $row + parent::buildRow($entity);
  }
}
