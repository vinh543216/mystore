<?php
/**
 * Created by PhpStorm.
 * User: lehoangvinh
 * Date: 10/5/2018
 * Time: 9:45 AM
 */

namespace Drupal\shopnew\Helper;

use Symfony\Component\HttpFoundation\Session\Session;

trait SessionTrail
{
  protected        $cart = 'product_cart';
  static protected $session;

  static function getSession()
  {
    if (self::$session === null) {
      self::$session = new Session();
    }
    return self::$session;
  }
}
