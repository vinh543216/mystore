<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 9/20/2018
 * Time: 12:38 AM
 */

namespace Drupal\shopnew\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\shopnew\Helper\SessionTrail;
use Drupal\shopnew\Model\ModelFactory;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ShopnewController extends ControllerBase
{
  use SessionTrail;

  function home()
  {
    return [];
  }

  function index()
  {
    $data = ModelFactory::getCategory()->getAll();
    // $this->cacheData('category', $data);
    //return new Response($category);
    return [
      '#data'     => $data ,
      '#theme'    => 'shopnew' ,
      '#attached' => [
        'library' => [
          'shopnew/shopnew_assets'
        ]
      ] ,
    ];
  }

  function setting()
  {
    return [
      '#data'  => [] ,
      '#theme' => 'shop_new_setting'
    ];
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container)
  {
    return new static(
    // Load the service required to construct this class.
      $container->get('sv.shopnew.category.model')
    );
  }


}
