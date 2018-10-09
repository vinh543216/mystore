<?php
/**
 * Created by PhpStorm.
 * User: lehoangvinh
 * Date: 10/1/2018
 * Time: 11:03 AM
 */

namespace Drupal\shopnew\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\shopnew\Helper\SessionHelper;

class OrderController extends ControllerBase
{
  function order()
  {
    $session = SessionHelper::getSession();
    $session->get(SessionHelper::CART);
  }
}
