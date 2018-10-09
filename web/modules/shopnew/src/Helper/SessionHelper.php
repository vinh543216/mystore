<?php

/**
 * Created by PhpStorm.
 * User: lehoangvinh
 * Date: 10/2/2018
 * Time: 4:14 PM
 */

namespace Drupal\shopnew\Helper;

use Symfony\Component\HttpFoundation\Session\Session;

class SessionHelper
{
  static protected $session;
  const CART = 'productCart';

  static function getSession()
  {
    if (self::$session === null) {
      self::$session = new Session();
    }
    return self::$session;
  }
}
