<?php
/**
 * Created by PhpStorm.
 * User: lehoangvinh
 * Date: 9/28/2018
 * Time: 9:02 AM
 */

namespace Drupal\shopnew\Form\product;

use Drupal\Core\Form\FormStateInterface;
use Drupal\shopnew\Form\FormWebBase;
use Drupal\shopnew\Helper\CommonHelper;

class AddForm extends FormWebBase
{
  function getFormId()
  {
    // TODO: Implement getFormId() method.
    return 'shop_new_product_form_add';
  }

  function buildForm(array $form , FormStateInterface $form_state)
  {
    // TODO: Implement buildForm() method.
    $listParentCategory = $this->categoryModel->getAll();
    $data = [];
    $form['title'] = [
      '#type'    => 'textfield' ,
      '#title'   => t('Title *: ') ,
      '#require' => TRUE
    ];
    $form['slug'] = [
      '#type'  => 'textfield' ,
      '#title' => t('Slug *:') ,
    ];
    $form['description'] = [
      '#type'  => 'textarea' ,
      '#title' => t('Description: ') ,
    ];
    $form['content'] = [
      '#type'   => 'text_format' ,
      '#title'  => t('Content: ') ,
      '#format' => 'full_html' ,
    ];
    $data[0] = '--- SELECT ---';
    //    $parent = CommonHelper::cateParent($listParentCategory);
    foreach ($listParentCategory as $category) {
      $data[$category->id] = $category->title;
    }
    $form['category'] = [
      '#prefix'        => '<div class="form-group">' ,
      '#type'          => 'select' ,
      '#title'         => t('Category: ') ,
      '#options'       => $data ,
      '#default_value' => $data[0] ,
      '#description'   => t('Description Select') ,
      '#suffix'        => '</div>'
    ];
    $form['image'] = array(
      '#type'              => 'managed_file' ,
      '#title'             => t('Image *: ') ,
      '#size'              => 20 ,
      '#description'       => t('PNG,JPG format only') ,
      //      '#multiple'          => '#multiple' ,
      '#upload_validators' => ['png' , 'jpg'] ,
      '#upload_location'   => 'public://my_files/' ,
    );
    $form['images'] = array(
      '#type'              => 'managed_file' ,
      '#title'             => t('ImagesList *: ') ,
      '#size'              => 20 ,
      '#description'       => t('PNG,JPG format only') ,
      '#multiple'          => '#multiple' ,
      '#upload_validators' => ['png' , 'jpg'] ,
      '#upload_location'   => 'public://my_files/' ,
    );
    $form['price'] = [
      '#type'  => 'textfield' ,
      '#title' => $this->t('Price *: ')
    ];
    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = [
      '#type'        => 'submit' ,
      '#value'       => $this->t('Save') ,
      '#button_type' => 'primary' ,
    ];
    return $form;

  }

  function validateForm(array &$form , FormStateInterface $form_state)
  {
    if (empty($form_state->getValue('title'))) {
      $form_state->setErrorByName('title' , t('Title is not empty'));
    }
    if (empty($form_state->getValue('slug'))) {
      $form_state->setErrorByName('slug' , t('Slug is not empty'));
    }
    if (empty($form_state->getValue('price'))) {
      $form_state->setErrorByName('price' , t('price is not empty'));
    }
    if (empty($form_state->getValue('image'))) {
      $form_state->setErrorByName('image' , t('image is not empty'));
    }
  }

  function submitForm(array &$form , FormStateInterface $form_state)
  {
    // TODO: Implement submitForm() method.
    if ($this->user->id()) {
      $imageId = $form_state->getValue('image');
      $imageId = $imageId[0];
      CommonHelper::addFileUsage($imageId);
      $imageListId = $form_state->getValue('images');
      if (!empty($imageListId)) {
        foreach ($imageListId as $img) {
          CommonHelper::addFileUsage($img);
        }
      }
      $product = [
        'title'       => $form_state->getValue('title') ,
        'description' => $form_state->getValue('description') ,
        'category_id' => $form_state->getValue('category') ,
        'image'       => $imageId ,
        'images'      => isset($imageListId) ? json_encode($imageListId) : '' ,
        'price'       => $form_state->getValue('price') ,
        'content'     => $form_state->getValue('content')['value'] ,
        'created_at'  => time() ,
        'slug'        => $form_state->getValue('slug')
      ];
      $reuslt = $this->productModel->save($product);
      if ($reuslt) {
        drupal_set_message(t('add success  @title' , ['@title' => $form_state->getValue('title')]));
      } else {
        drupal_set_message(t('add  @title  error' , ['@title' => $form_state->getValue('title')]));
      }
      $form_state->setRedirect('shopnew.admin_product_list');
    }
  }
}

