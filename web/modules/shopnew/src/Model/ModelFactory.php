<?php
/**
 * Created by PhpStorm.
 * User: lehoangvinh
 * Date: 10/4/2018
 * Time: 3:23 PM
 */

namespace Drupal\shopnew\Model;


class ModelFactory
{
  static protected $product;
  static protected $category;
  static protected $order;
  static protected $orderDetail;

  static function getProduct()
  {
    if (self::$product === null) {
      self::$product = new ProductModel();
    }
    return self::$product;
  }

  static function getCategory()
  {
    if (self::$category === null) {
      self::$category = new CategoryModel();
    }
    return self::$category;
  }

  static function getOder()
  {
    if (self::$order === null) {
      self::$order = new OrderModel();
    }
    return self::$order;
  }

  static function getOrderDetail()
  {
    if (self::$orderDetail === null) {
      self::$orderDetail = new OrderDetailModel();
    }
    return self::$orderDetail;
  }
}
