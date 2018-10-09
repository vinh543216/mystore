<?php
/**
 * Created by PhpStorm.
 * User: lehoangvinh
 * Date: 9/28/2018
 * Time: 9:38 AM
 */

namespace Drupal\shopnew\Form;

use Drupal\Core\Form\FormBase;
use Drupal\shopnew\Model\CategoryModel;
use Drupal\shopnew\Model\ProductModel;
use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class FormWebBase extends FormBase
{
  protected $user;
  protected $categoryModel;
  protected $productModel;

  function __construct(CategoryModel $categoryModel , ProductModel $productModel)
  {
    $this->user = \Drupal::currentUser();
    $this->categoryModel = $categoryModel;
    $this->productModel = $productModel;
  }

  static function create(ContainerInterface $container)
  {
    return new static(
      $container->get('sv.shopnew.category.model') ,
      $container->get('sv.shopnew.product.model')
    );
  }
}


