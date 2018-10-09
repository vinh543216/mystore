<?php
/**
 * Created by PhpStorm.
 * User: lehoangvinh
 * Date: 9/28/2018
 * Time: 10:41 AM
 */

namespace Drupal\shopnew\Form\product;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\shopnew\Form\FormWebBase;

class ListForm extends FormWebBase
{
  function getFormId()
  {
    // TODO: Implement getFormId() method.
  }

  function buildForm(array $form , FormStateInterface $form_state)
  {
    // TODO: Implement buildForm() method.
    $data = [];
    $header = [
      'ID' , 'Title' , 'Description' , 'Category' , 'created_at' , 'Edit' , 'Delete'
    ];
    $form = [];
    $form['#prefix'] = '<div class="my-form-class"><a href="' . $this->url('shopnew.admin_product_add') . '" class="button">Add Product</a>';
    $form['#suffix'] = '</div>';
    $form['filters'] = [
      '#type'  => 'fieldset' ,
      '#title' => $this->t('Filter Product') ,
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
      '#value' => $this->t('Search')
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
    $params = $this->productModel->searchByParam($condition , $search);
    if (!empty($params)) {
      foreach ($params as $result) {
        $delete = Url::fromUserInput('/admin/shop-new/product/delete/' . $result->id);
        $edit = Url::fromUserInput('/admin/shop-new/product/edit?num=' . $result->id);
        $data[] = [
          'id'          => $result->id ,
          'title'       => $result->title ,
          'description' => $result->description ,
          'category'    => $result->category_id ,
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

  function validateForm(array &$form , FormStateInterface $form_state)
  {
    parent::validateForm($form , $form_state); // TODO: Change the autogenerated stub
  }

  function submitForm(array &$form , FormStateInterface $form_state)
  {
    // TODO: Implement submitForm() method.
  }
}
