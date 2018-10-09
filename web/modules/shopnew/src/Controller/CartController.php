<?php
/**
 * Created by PhpStorm.
 * User: lehoangvinh
 * Date: 10/3/2018
 * Time: 3:11 PM
 */

namespace Drupal\shopnew\Controller;

use Drupal\Console\Bootstrap\Drupal;
use Drupal\Core\Controller\ControllerBase;
use Drupal\shopnew\Helper\SessionHelper;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CartController extends ControllerBase
{
  /**
   *  function add a product to cart
   * @return array
   *
   */
  function addToCart()
  {
    $data = [];
    $total = 0;
    $session = \Drupal::request()->getSession();
    if ($session->has(SessionHelper::CART) && !empty($session->get(SessionHelper::CART))) {
      $product = $session->get(SessionHelper::CART);
      foreach ($product as &$value) {
        $total += $value['price'] * $value['quality'];
        $value['price'] = number_format($value['quality'] * $value['price'] , '0' , ',' , '.');
      }
      $data['product'] = $product;
      $data['total'] = number_format($total , '0' , ',' , '.');
    }
    foreach ($session->getFlashBag()->get('message' , array()) as $message) {
      $data['message'] = $message;
    }
    return [
      '#theme'    => 'add_to_cart' ,
      '#data'     => $data ,
      '#attached' => [
        'library' => [
          'shopnew/shopnew_assets'
        ]
      ]
    ];
  }

  /**
   * function delete a product in cart
   * @param $id
   * @return Response
   */
  function delete($id)
  {
    $productUpdate = [];
    $session = SessionHelper::getSession();
    if ($session->has(SessionHelper::CART) && !empty($session->get(SessionHelper::CART))) {
      $listCart = $session->get(SessionHelper::CART);
      foreach ($listCart as $key => $cart) {
        if ($cart['id'] == $id) {
          unset($key);
        } else {
          $productUpdate[] = $cart;
        }
      }
      if (empty($productUpdate)) {
        $session->remove(SessionHelper::CART);
      } else {
        $session->set(SessionHelper::CART , $productUpdate);
      }
      $session->getFlashBag()->add('message' , t('Delete success'));
      \Drupal::service('router.builder')
        ->rebuild();
      return new Response(json_encode(['message' => t('Delete success')]));
    }
    $session->getFlashBag()->add('message' , 'Delete error');
    \Drupal::service('router.builder')
      ->rebuild();
    return new Response(json_encode(['message' => t('Delete error')]));
  }

  /**
   * function update a product in cart
   * @param Request $request
   * @return Response
   */
  function update(Request $request)
  {
    $session = SessionHelper::getSession();
    $id = $request->get('id');
    $quality = $request->get('quality');
    if (!empty($id) && is_numeric($id) && is_numeric($quality)) {
      if ($session->has(SessionHelper::CART) && !empty($session->get(SessionHelper::CART))) {
        $listCart = $session->get(SessionHelper::CART);
        $found = false;
        foreach ($listCart as $item) {
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
        }
      }
      $session->getFlashBag()->add('message' , t('Update cart success'));
      \Drupal::service('router.builder')
        ->rebuild();
      return new Response(json_encode(['message' => 'success']));
    }
    $session->getFlashBag()->add('message' , t('Update cart error! invalid'));
    \Drupal::service('router.builder')
      ->rebuild();
    return new Response(json_encode(['message' => 'error']));
  }
}
