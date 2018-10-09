<?php
/**
 * Created by PhpStorm.
 * User: lehoangvinh
 * Date: 9/28/2018
 * Time: 11:29 AM
 */

namespace Drupal\shopnew\Form\product;

use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\file\Entity\File;
use Drupal\shopnew\Model\ModelFactory;

class DeleteForm extends ConfirmFormBase
{
  public $cid;

  function getFormId()
  {
    // TODO: Implement getFormId() method.
    return 'shop_new_product_form_delete';
  }

  public function getQuestion()
  {
    return t('Do you want to delete product %cid ?' , array('%cid' => $this->cid));
  }

  public function getCancelUrl()
  {
    return new Url('shopnew.admin_product_list');
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

  public function buildForm(array $form , FormStateInterface $form_state , $cid = NULL)
  {
    $this->cid = $cid;
    return parent::buildForm($form , $form_state);
  }


  function validateForm(array &$form , FormStateInterface $form_state)
  {
    parent::validateForm($form , $form_state); // TODO: Change the autogenerated stub
  }

  public function submitForm(array &$form , FormStateInterface $form_state)
  {
    $product = ModelFactory::getProduct()->getById($this->cid);
    if (!empty($product)) {
      ModelFactory::getProduct()->delete($this->cid);
      $file = File::load($product->image);
      if ($file) {
        file_delete($product->image);
      }
      $listImages = json_decode($product->images);
      if (!empty($listImages)) {
        foreach ($listImages as $img) {
          $imagesFile = File::load($img);
          if ($imagesFile) {
            file_delete($img);
          }
        }
      }
      drupal_set_message("succesfully deleted");
      $form_state->setRedirect('shopnew.admin_product_list');
    } else {
      drupal_set_message("deleted category no exist");
      $form_state->setRedirect('shopnew.admin_product_list');
    }
  }
}
