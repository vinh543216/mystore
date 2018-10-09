<?php
/**
 * Created by PhpStorm.
 * User: lehoangvinh
 * Date: 10/4/2018
 * Time: 3:37 PM
 */

namespace Drupal\shopnew\Form\order;

use Drupal\Core\Form\FormStateInterface;
use Drupal\shopnew\Form\FormWebBase;
use Drupal\shopnew\Helper\SessionHelper;
use Drupal\shopnew\Model\ModelFactory;

class OrderForm extends FormWebBase
{

  protected $listCart;

  function getFormId()
  {
    // TODO: Implement getFormId() method.
    return 'shop_new_form_order';
  }

  function buildForm(array $form , FormStateInterface $form_state)
  {
    // TODO: Implement buildForm() method.
    // TODO: Implement buildForm() method.
    $this->listCart = SessionHelper::getSession()->get(SessionHelper::CART);
    $userName = $this->user->getDisplayName();
    $data = [];
    $form['username'] = [
      '#type'          => 'textfield' ,
      '#title'         => t('Username') ,
      '#require'       => TRUE ,
      '#default_value' => isset($userName) ? $userName : ''
    ];
    $form['phone'] = [
      '#type'    => 'textfield' ,
      '#title'   => t('Phone') ,
      '#require' => TRUE ,
    ];
    $form['address'] = [
      '#type'  => 'textarea' ,
      '#title' => t('Address') ,
    ];
    $total = 0;
    foreach ($this->listCart as $product) {
      $total += $product['price'];
    }
    $form['total'] = [
      '#type'          => 'textfield' ,
      '#title'         => t('Total') ,
      '#default_value' => isset($total) ? $total : ''
    ];
    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = [
      '#type'        => 'submit' ,
      '#value'       => t('Save') ,
      '#button_type' => 'primary' ,
    ];
    return $form;
  }

  function validateForm(array &$form , FormStateInterface $form_state)
  {
    parent::validateForm($form , $form_state); // TODO: Change the autogenerated stub
  }

  function submitForm(array &$form , FormStateInterface $form_state)
  {
    // TODO: Implement submitForm() method.
    if ($this->user->id()) {
      $order = [
        'user_id'    => $this->user->id() ,
        'user_name'  => $form_state->getValue('username') ,
        'phone'      => $form_state->getValue('phone') ,
        'address'    => $form_state->getValue('address') ,
        'total'      => $form_state->getValue('total') ,
        'created_at' => time()
      ];
      $orderId = ModelFactory::getOder()->save($order);
      $orderDetail = [];
      foreach ($this->listCart as &$prod) {
        $prod['orderId'] = $orderId;
        $orderDetail[] = [
          'order_id'   => $orderId ,
          'quality'    => $prod['quality'] ,
          'price'      => $prod['price'] ,
          'product_id' => $prod['id']
        ];
      }
      ModelFactory::getOrderDetail()->save($orderDetail);
      SessionHelper::getSession()->remove(SessionHelper::CART);
      \Drupal::service("router.builder")->rebuild();
      drupal_set_message($this->t('Order success '));
      $form_state->setRedirect('shopnew.home');
    }
  }
}