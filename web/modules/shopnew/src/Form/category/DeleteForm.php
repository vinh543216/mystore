<?php
/**
 * Created by PhpStorm.
 * User: lehoangvinh
 * Date: 9/25/2018
 * Time: 9:06 AM
 */

namespace Drupal\shopnew\Form\category;

use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\file\Entity\File;
use Drupal\shopnew\Model\Category;
use Drupal\shopnew\Model\ModelFactory;

class DeleteForm extends ConfirmFormBase
{
  /**
   * {@inheritdoc}
   */
  public function getFormId()
  {
    return 'shop_new_category_form_delete';
  }

  public $cid;

  public function getQuestion()
  {
    return t('Do you want to delete category %cid ?' , array('%cid' => $this->cid));
  }

  public function getCancelUrl()
  {
    return new Url('shopnew.admin_category_list');
  }

  public function getDescription()
  {
    //    return t('Are you sure delete it !');
  }

  /**
   * {@inheritdoc}
   */
  public function getConfirmText()
  {
    return t('Delete');
  }

  /**
   * {@inheritdoc}
   */
  public function getCancelText()
  {
    return t('Cancel');
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form , FormStateInterface $form_state , $cid = NULL)
  {
    $this->cid = $cid;
    return parent::buildForm($form , $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form , FormStateInterface $form_state)
  {
    parent::validateForm($form , $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form , FormStateInterface $form_state)
  {
    $category = ModelFactory::getCategory()->getById($this->cid);
    $file = File::load($category->image);
    if (!empty($category)) {
      ModelFactory::getCategory()->delete($this->cid);
      if ($file) {
        file_delete($category->image);
      }
      drupal_set_message("succesfully deleted");
      $form_state->setRedirect('shopnew.admin_category_list');
    } else {
      drupal_set_message("deleted category no exist");
      $form_state->setRedirect('shopnew.admin_category_list');
    }
  }
}
