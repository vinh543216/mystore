<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 9/25/2018
 * Time: 12:47 AM
 */

namespace Drupal\shopnew\Form\category;

use Drupal\Core\Database\Database;
use Drupal\Core\Form\FormStateInterface;
use Drupal\file\Entity\File;
use Drupal\shopnew\Form\FormWebBase;
use Drupal\shopnew\Helper\CommonHelper;

class EditForm extends FormWebBase
{

  protected $url;


  public function getFormId()
  {
    // TODO: Implement getFormId() method.
    return 'shop_new_category_form_edit';
  }

  public function buildForm(array $form , FormStateInterface $form_state)
  {
    $conn = Database::getConnection();
    $record = array();
    if (isset($_GET['num'])) {
      $query = $conn->select('shopnew_category' , 'snc')
        ->condition('id' , $_GET['num'])
        ->fields('snc');
      $record = $query->execute()->fetchAssoc();
    }
    $form['title'] = array(
      '#type'          => 'textfield' ,
      '#title'         => t('Title *:') ,
      '#required'      => TRUE ,
      '#default_value' => (isset($record['title']) && $_GET['num']) ? $record['title'] : '' ,
    );
    $form['slug'] = [
      '#type'          => 'textfield' ,
      '#title'         => t('Slug *:') ,
      '#default_value' => (isset($record['slug']) && $_GET['num']) ? $record['slug'] : ''
    ];
    $form['description'] = [
      '#type'          => 'textarea' ,
      '#title'         => t('Description:') ,
      '#default_value' => (isset($record['description']) && $_GET['num']) ? $record['description'] : ''
    ];

    $listParentCategory = $conn->select('shopnew_category' , 'ls')
      ->fields('ls')
      ->execute()->fetchAll();
    $data = [];
    $listId = [];
    $data[0] = '--- SELECT ---';
    foreach ($listParentCategory as $category) {
      $data[$category->id] = $category->title;
      $listId[$category->id] = $category->id;
    }
    if (File::load($record['image'])) {
      $this->url = file_create_url(File::load($record['image'])->getFileUri());
    }
    $form['category'] = [
      '#prefix'        => '<div class="form-group">' ,
      '#type'          => 'select' ,
      '#title'         => t('Category') ,
      '#options'       => $data ,
      '#default_value' => (isset($record['id']) && $_GET['num'] && in_array($record['parent_id'] , $listId)) ? $listId[$record['parent_id']] : $data[0] ,
      '#description'   => 'description select' ,
      '#suffix'        => '</div>'
    ];
    $form['imageOld'] = [
      '#prefix'        => '<div class="form-group">' ,
      '#type'          => 'hidden' ,
      '#default_value' => (isset($record['image']) && $_GET['num']) ? $record['image'] : '' ,
      '#suffix'        => '<img  width="10%" src="' . $this->url . '"></div>'
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

  public function validateForm(array &$form , FormStateInterface $form_state)
  {
    if (empty($form_state->getValue('title'))) {
      $form_state->setErrorByName('title' , $this->t('Title is not empty'));
    }
    if (empty($form_state->getValue('slug'))) {
      $form_state->setErrorByName('slug' , $this->t('Slug is not empty'));
    }
  }

  public function submitForm(array &$form , FormStateInterface $form_state)
  {
    // TODO: Implement submitForm() method.
    if ($this->user->id()) {
      $fileIdOld = $form_state->getValue('imageOld');
      $file = $form_state->getValue('image');
      if (!empty($file)) {
        CommonHelper::addFileUsage($file[0]);
        $file = File::load($file[0]);
        $fileId = $file->id();
        file_delete($fileIdOld);
      }
      $category = [
        'title'       => $form_state->getValue('title') ,
        'description' => $form_state->getValue('description') ,
        'slug'        => $form_state->getValue('slug') ,
        'parent_id'   => $form_state->getValue('category') ,
        'image'       => isset($fileId) ? $fileId : $fileIdOld ,
        'updated_at'  => time()
      ];
      $this->categoryModel->edit($category , $_GET['num']);
      drupal_set_message($this->t('succesfully updated  @title' , ['@title' => $form_state->getValue('title')]));
      $form_state->setRedirect('shopnew.admin_category_list');
    }
  }
}
