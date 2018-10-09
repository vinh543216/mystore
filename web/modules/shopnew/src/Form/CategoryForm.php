<?php

namespace Drupal\shopnew\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\shopnew\Model\Category;

/**
 * Implements an example form.
 */
class CategoryForm extends FormWebBase
{

  /**
   * {@inheritdoc}
   */
  public function getFormId()
  {
    return 'shopnew_category_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form , FormStateInterface $form_state)
  {
    $form['title'] = [
      '#type'  => 'textfield' ,
      '#title' => t('Title:') ,
    ];
    $form['description'] = [
      '#type'  => 'textarea' ,
      '#title' => t('Description:') ,
    ];
    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = [
      '#type'        => 'submit' ,
      '#value'       => t('Save') ,
      '#button_type' => 'primary' ,
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form , FormStateInterface $form_state)
  {
    if (strlen($form_state->getValue('title')) < 3) {
      $form_state->setErrorByName('title' , $this->t('The title is too short. Please enter a full phone number.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form , FormStateInterface $form_state)
  {
    $category = [
      'title'       => $form_state->getValue('title') ,
      'description' => $form_state->getValue('description')
    ];
    $this->categoryModel->save($category);
    drupal_set_message($this->t('add success  @title' , ['@title' => $form_state->getValue('title')]));
  }

}
