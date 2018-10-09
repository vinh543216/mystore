<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 9/23/2018
 * Time: 3:53 PM
 */

namespace Drupal\shopnew\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\shopnew\Model\ModelFactory;

class CategoryController extends ControllerBase
{
  function add()
  {
    $data['title'] = t('Add new Category');
    $data['form'] = \Drupal::formBuilder()
      ->getForm('Drupal\shopnew\Form\category\AddForm');
    return [
      '#theme'    => 'category_add' ,
      '#data'     => $data ,
      '#attached' => array(
        'library' => [] ,
      ) ,
    ];
  }

  function categoryList()
  {
    $data = [];
    $category = ModelFactory::getCategory()->getAll();
    if (!empty($category)) {
      $data = \Drupal::formBuilder()
        ->getForm('Drupal\shopnew\Form\category\ListForm' , $category);
    }
    return [
      '#theme' => 'category_list' ,
      '#data'  => $data
    ];
  }
}
