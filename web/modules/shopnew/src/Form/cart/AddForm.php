<?php
/**
 * Created by PhpStorm.
 * User: lehoangvinh
 * Date: 10/2/2018
 * Time: 3:36 PM
 */

namespace Drupal\shopnew\Form\cart;

use Drupal\Core\Form\FormStateInterface;
use Drupal\shopnew\Form\FormWebBase;
use Drupal\shopnew\Helper\SessionHelper;
use Drupal\shopnew\Helper\SessionTrail;


class AddForm extends FormWebBase
{
  use SessionTrail;

  function getFormId()
  {
    // TODO: Implement getFormId() method.
    return 'shop_new_cart_form_add';
  }

  function buildForm(array $form , FormStateInterface $form_state , $data = [])
  {
    // TODO: Implement buildForm() method.
    $form = [];
    $form['id'] = [
      '#type'          => 'hidden' ,
      '#default_value' => isset($data->id) ? $data->id : ''
    ];
    $form['quality'] = [
      '#type'          => 'textfield' ,
      '#title'         => t('Quality') ,
      '#size'          => 3 ,
      '#default_value' => 1
    ];
    $form['action']['submit'] = [
      '#type'        => 'submit' ,
      '#value'       => t('Add Cart') ,
      '#button_type' => 'primary' ,
    ];
    return $form;
  }

  function validateForm(array &$form , FormStateInterface $form_state)
  {
    if (empty($form_state->getValue('quality'))) {
      $form_state->setErrorByName('quality' , t('quality is not empty'));
    }
    if (!is_numeric($form_state->getValue('quality'))) {
      $form_state->setErrorByName('quality' , t('quality is number'));
    }
  }

  function submitForm(array &$form , FormStateInterface $form_state)
  {
    // TODO: Implement submitForm() method.
    $session = \Drupal::request()->getSession();
    $id = $form_state->getValue('id');
    $quality = $form_state->getValue('quality');
    if (!empty($id) && is_numeric($id) && !empty($quality) && is_numeric($quality)) {
      $product = $this->productModel->getById($id);
      $newProduct[] = [
        'id'      => $product->id ,
        'title'   => $product->title ,
        'quality' => $quality ,
        'price'   => $product->price
      ];
      if (!empty($product)) {
        if ($session->has(SessionHelper::CART) && !empty($session->get(SessionHelper::CART))) {
          $found = false;
          $value = $session->get(SessionHelper::CART);
          foreach ($value as $item) {
            if ($item['id'] == $id) {
              $data[] = [
                'id'      => $item['id'] ,
                'title'   => $item['title'] ,
                'quality' => $quality ,
                'price'   => $item['price']
              ];
              $found = true;
            } else {
              $data[] = [
                'id'      => $item['id'] ,
                'title'   => $item['title'] ,
                'quality' => $item['quality'] ,
                'price'   => $item['price']
              ];
            }
          }
          if ($found == true) {
            $session->set(SessionHelper::CART , $data);
          } else {
            $session->set(SessionHelper::CART , array_merge($data , $newProduct));
          }
        } else {
          $session->set(SessionHelper::CART , $newProduct);
        }
      }
      \Drupal::service('router.builder')
        ->rebuild();
      $form_state->setRedirect('shopnew.add_to_cart');
    }
  }
}
