<?php

namespace Drupal\ad_custom_entity\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Language\Language;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for the MyEntity entity edit forms.
 *
 * @ingroup ad_custom_entity
 */
class MyEntityForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $status = parent::save($form, $form_state);
    $entity = $this->entity;

    if ($status == SAVED_UPDATED) {
      drupal_set_message($this->t('The %title has been updated.', ['%title' => $entity->toLink()->toString()]));
    }
    else {
      drupal_set_message($this->t('The %title has been added.', ['%title' => $entity->toLink()->toString()]));
    }

    return $status;
  }
}
