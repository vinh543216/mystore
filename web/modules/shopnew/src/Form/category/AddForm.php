<?php

namespace Drupal\shopnew\Form\category;

use Drupal\Core\Form\FormStateInterface;
use Drupal\shopnew\Form\FormWebBase;
use Drupal\shopnew\Helper\CommonHelper;
use Drupal\shopnew\Model\Category;
use Drupal\shopnew\Model\ModelFactory;

/**
 * Implements an example form.
 */
class AddForm extends FormWebBase
{


  /**
   * {@inheritdoc}
   */
  public function getFormId()
  {
    return 'shop_new_category_form_add';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form , FormStateInterface $form_state)
  {
    $record = ModelFactory::getCategory();
    $listParentCategory = $record->getAll();
    $data = [];
    $form['title'] = [
      '#type'  => 'textfield' ,
      '#title' => t('Title') ,
    ];
    $form['slug'] = [
      '#type'  => 'textfield' ,
      '#title' => t('Slug') ,
    ];
    $form['description'] = [
      '#type'  => 'textarea' ,
      '#title' => t('Description') ,
    ];
    $data[0] = '--- SELECT ---';
    //    $parent = CommonHelper::cate_parent($listParentCategory);
    foreach ($listParentCategory as $category) {
      $data[$category->id] = $category->title;
    }
    $form['category'] = [
      '#prefix'        => '<div class="form-group">' ,
      '#type'          => 'select' ,
      '#title'         => t('Category') ,
      '#options'       => $data ,
      '#default_value' => $data[0] ,
      '#description'   => t('description select') ,
      '#suffix'        => '</div>'
    ];
    $form['image'] = array(
      '#type'              => 'managed_file' ,
      '#title'             => t('File *') ,
      '#size'              => 20 ,
      '#description'       => t('PNG,JPG format only') ,
      //      '#multiple'          => '#multiple' ,
      '#upload_validators' => ['png' , 'jpg'] ,
      '#upload_location'   => 'public://my_files/' ,
    );
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
    if (empty($form_state->getValue('title'))) {
      $form_state->setErrorByName('title' , $this->t('Title is not empty'));
    }
    if (empty($form_state->getValue('slug'))) {
      $form_state->setErrorByName('slug' , $this->t('Slug is not empty'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form , FormStateInterface $form_state)
  {
    if ($this->user->id()) {
      $fileId = '';
      $file = $form_state->getValue('image');
      if (!empty($file)) {
        CommonHelper::addFileUsage($file[0]);
        $fileId = $file[0];
      }
      $category = [
        'title'       => $form_state->getValue('title') ,
        'description' => $form_state->getValue('description') ,
        'slug'        => $form_state->getValue('slug') ,
        'parent_id'   => $form_state->getValue('category') ,
        'image'       => $fileId ,
        'created_at'  => time()
      ];
      $record = ModelFactory::getCategory();
      $record->save($category);
      drupal_set_message($this->t('add success  @title' , ['@title' => $form_state->getValue('title')]));
      $form_state->setRedirect('shopnew.admin_category_list');
    }
  }
}
