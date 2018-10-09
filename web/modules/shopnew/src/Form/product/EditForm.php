<?php
/**
 * Created by PhpStorm.
 * User: lehoangvinh
 * Date: 9/28/2018
 * Time: 11:27 AM
 */

namespace Drupal\shopnew\Form\product;

use Drupal\Core\Form\FormStateInterface;
use Drupal\file\Entity\File;
use Drupal\shopnew\Form\FormWebBase;
use Drupal\shopnew\Helper\CommonHelper;

class EditForm extends FormWebBase
{
  function getFormId()
  {
    // TODO: Implement getFormId() method.
    return 'shop_new_product_form_edit';
  }

  function buildForm(array $form , FormStateInterface $form_state)
  {
    // TODO: Implement buildForm() method.
    if (!isset($_GET['num'])) {
      return $this->redirect('shopnew.admin_product_list');
    }
    $record = $this->productModel->getById($_GET['num']);
    if (empty($record)) {
      drupal_set_message($this->t('product not exits'));
      return $this->redirect('shopnew.admin_product_list');
    }
    $form['title'] = array(
      '#type'          => 'textfield' ,
      '#title'         => t('Title:') ,
      '#required'      => TRUE ,
      '#default_value' => (isset($record->title) && $_GET['num']) ? $record->title : '' ,
    );
    $form['slug'] = [
      '#type'          => 'textfield' ,
      '#title'         => $this->t('Slug *:') ,
      '#required'      => TRUE ,
      '#default_value' => (isset($record->slug) && $_GET['num']) ? $record->slug : '' ,
    ];
    $form['description'] = [
      '#type'          => 'textarea' ,
      '#title'         => $this->t('Description:') ,
      '#default_value' => (isset($record->description) && $_GET['num']) ? $record->description : ''
    ];
    $form['content'] = [
      '#type'          => 'text_format' ,
      '#title'         => $this->t('Content: ') ,
      '#default_value' => (isset($record->content) && $_GET['num']) ? $record->content : '' ,
      '#format'        => 'full_html' ,
    ];
    $category = $this->categoryModel->getAll();
    $data = [];
    $listId = [];
    $data[0] = '--- SELECT ---';
    foreach ($category as $value) {
      $data[$value->id] = $value->title;
      $listId[$value->id] = $value->id;
    }
    if (File::load($record->image)) {
      $urlImage = file_create_url(File::load($record->image)->getFileUri());
    }
    $images = isset($record->images) ? json_decode($record->images) : '';
    $form['category'] = [
      '#prefix'        => '<div class="form-group">' ,
      '#type'          => 'select' ,
      '#title'         => $this->t('category') ,
      '#options'       => $data ,
      '#default_value' => (isset($record->id) && $_GET['num'] && in_array($record->category_id , $listId)) ? $listId[$record->category_id] : $data[0] ,
      '#description'   => 'description select' ,
      '#suffix'        => '</div>'
    ];
    $form['image'] = array(
      '#type'              => 'managed_file' ,
      '#title'             => t('Image *') ,
      '#size'              => 20 ,
      '#description'       => t('PNG,JPG format only') ,
      '#upload_validators' => ['png' , 'jpg'] ,
      '#upload_location'   => 'public://my_files/' ,
    );
    $form['image_' . $record->image] = [
      '#prefix' => '<div class="form-group">' ,
      '#suffix' => (isset($urlImage)) ? '<img  width="10%" src="' . $urlImage . '"></div>' : ''
    ];
    $form['imageOld'] = [
      '#type'          => 'hidden' ,
      '#default_value' => (isset($record->image) && $_GET['num']) ? $record->image : '' ,
    ];

    $form['images'] = [
      '#type'              => 'managed_file' ,
      '#title'             => t('ImagesList *:') ,
      '#size'              => 20 ,
      '#description'       => t('PNG,JPG format only') ,
      '#multiple'          => '#multiple' ,
      '#upload_validators' => ['png' , 'jpg'] ,
      '#upload_location'   => 'public://my_files/' ,
    ];
    $form['imagesOld'] = [
      '#type'          => 'hidden' ,
      '#default_value' => (isset($record->images) && $_GET['num']) ? $record->images : '' ,
    ];
    foreach ($images as $img) {
      if (File::load($record->image)) {
        $url_images = file_create_url(File::load($img)->getFileUri());
        $form['list_images_' . $img] = [
          '#prefix' => '<span class="form-group">' ,
          '#suffix' => '<img  width="10%" src="' . $url_images . '"></span>'
        ];
      }
    }
    $form['price'] = [
      '#type'          => 'textfield' ,
      '#title'         => $this->t('Price *: ') ,
      '#default_value' => (isset($record->price) && $_GET['num']) ? $record->price : '' ,
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
      $form_state->setErrorByName('title' , $this->t('Title is not empty'));
    }
    if (empty($form_state->getValue('slug'))) {
      $form_state->setErrorByName('slug' , $this->t('Slug is not empty'));
    }

    if (empty($form_state->getValue('price'))) {
      $form_state->setErrorByName('price' , $this->t('price is not empty'));
    }
  }

  function submitForm(array &$form , FormStateInterface $form_state)
  {
    // TODO: Implement submitForm() method.
    // TODO: Implement submitForm() method.
    if ($this->user->id()) {
      $imageIdOld = $form_state->getValue('imageOld');
      $imageId = $form_state->getValue('image');
      $listImagesId = $form_state->getValue('images');
      $listImagesIdOld = $form_state->getValue('imagesOld');
      if (!empty($imageId)) {
        $imageId = $imageId[0];
        CommonHelper::addFileUsage($imageId);
        file_delete($imageIdOld);
      }
      if (!empty($listImagesId)) {
        foreach ($listImagesId as $img) {
          CommonHelper::addFileUsage($img);
        }
        if (!empty($listImagesIdOld)) {
          $listImagesIdOld = json_decode($listImagesIdOld);
          foreach ($listImagesIdOld as $img) {
            file_delete($img);
          }
        }
      }
    }
    $product = [
      'title'       => $form_state->getValue('title') ,
      'description' => $form_state->getValue('description') ,
      'content'     => $form_state->getValue('content')['value'] ,
      'category_id' => $form_state->getValue('category') ,
      'image'       => !empty($imageId) ? $imageId : $imageIdOld ,
      'images'      => !empty($listImagesId) ? json_encode($listImagesId) : $listImagesIdOld ,
      'price'       => $form_state->getValue('price') ,
      'updated_at'  => time() ,
      'slug'        => !empty($form_state->getValue('slug')) ? $form_state->getValue('slug') : ''
    ];
    $record = $this->productModel->edit($product , $_GET['num']);
    if ($record) {
      drupal_set_message($this->t('succesfully updated  @title' , ['@title' => $form_state->getValue('title')]));
      $form_state->setRedirect('shopnew.admin_product_list');
    } else {
      drupal_set_message($this->t('succesfully updated  @title' , ['@title' => $form_state->getValue('title')]));
      $form_state->setRedirect('shopnew.admin_product_list');
    }
  }
}
