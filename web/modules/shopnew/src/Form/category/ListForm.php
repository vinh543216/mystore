<?php

namespace Drupal\shopnew\Form\category;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\shopnew\Form\FormWebBase;
use Drupal\shopnew\Model\Category;

/**
 * Implements an example form.
 */
class ListForm extends FormWebBase
{
  /**
   * {@inheritdoc}
   */
  public function getFormId()
  {
    return 'shop_new_category_form_list';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form , FormStateInterface $form_state)
  {
    $data = [];
    $header = [
      'ID' , 'Title' , 'Description' , 'slug' , 'ParentId' , 'created_at' , 'Edit' , 'Delete'
    ];
    $form = [];
    $form['#prefix'] = '<div class="my-form-class"><a href="' . $this->url('shopnew.admin_category_add') . '" class="button">Add category</a>';
    $form['#suffix'] = '</div>';
    $form['filters'] = [
      '#type'  => 'fieldset' ,
      '#title' => t('Filter Category') ,
      '#open'  => true ,
    ];
    $form['filters']['title'] = [
      '#title'         => t('Title:') ,
      '#type'          => 'textfield' ,
      '#size'          => 15 ,
      '#default_value' => isset($form_state->getStorage()['search']) ? $form_state->getStorage()['search'] : ''
    ];
    $form['filters']['created_at'] = array(
      '#type'          => 'date' ,
      '#title'         => t('Created at') ,
      '#default_value' => ''
    );

    $form['filters']['actions'] = [
      '#type'  => 'submit' ,
      '#value' => t('Search')
    ];
    $condition = [];
    $search = [];

    if (!empty($form_state->getStorage()['created_at'])) {
      $condition = [
        'created_at' => $form_state->getStorage()['created_at']
      ];
    }
    if (!empty($form_state->getStorage()['search'])) {
      $search = [
        'title' => $form_state->getStorage()['search']];
    }
    $params = $this->categoryModel->searchByParam($condition , $search);
    if (!empty($params)) {
      foreach ($params as $result) {
        $delete = Url::fromUserInput('/admin/shop-new/category/delete/' . $result->id);
        $edit = Url::fromUserInput('/admin/shop-new/category/edit?num=' . $result->id);
        $data[] = [
          'id'          => $result->id ,
          'title'       => $result->title ,
          'description' => $result->description ,
          'slug'        => $result->slug ,
          'parentId'    => $result->parent_id ,
          'created'     => date('d/m/Y' , $result->created_at) ,
          \Drupal::l('Edit' , $edit) ,
          \Drupal::l('Delete' , $delete) ,
        ];
      }
    }
    $form ['table'] = [
      '#theme'  => 'table' ,
      '#header' => $header ,
      '#rows'   => $data ,
    ];
    $form['pager'] = array(
      '#type' => 'pager'
    );
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form , FormStateInterface $form_state)
  {

  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form , FormStateInterface $form_state)
  {

    $form_state->getStorage()['created_at'] = $form_state->getValues()['created_at'];
    $form_state->getStorage()['search'] = $form_state->getValues()['title'];
    //    foreach ($form_state->getValues() as $key => $value) {
    //      drupal_set_message($key . ': ' . $value);
    //    }
    $form_state->setRebuild();
  }
}
