<?php

namespace Drupal\ad_custom_entity\Entity\Controller;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;
use Drupal\Core\Url;

/**
 * Provides a list controller for MyEntity entity.
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
      '#markup' => $this->t('AD Custom Entity implements a MyEntity model. These myentities are fieldable entities. You can manage the fields on the MyEntity settings <a href="@adminlink">page</a>.', [
        '@adminlink' => \Drupal::urlGenerator()
          ->generateFromRoute('ad_custom_entity_myentity.myentity_settings'),
      ]),
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
    $link = '';
    if (!empty($entity->link->uri)) {
      $link_url = Url::fromUri($entity->link->uri);
      $link = Link::fromTextAndUrl($entity->link->title, $link_url);
    }
    $row['link'] = $link;
    $row['language'] = $entity->langcode->value;
    return $row + parent::buildRow($entity);
  }
}
