<?php
/**
 * Created by PhpStorm.
 * User: lehoangvinh
 * Date: 9/28/2018
 * Time: 8:54 AM
 */

namespace Drupal\shopnew\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\shopnew\Helper\CommonHelper;
use Drupal\shopnew\Model\CategoryModel;
use Drupal\shopnew\Model\ModelFactory;
use Drupal\shopnew\Model\ModelTest;
use Drupal\shopnew\Model\ProductModel;

class ProductController extends ControllerBase
{
  /**
   * function get detail
   *
   */
  function detail($id)
  {
    $data = [];
    if (!empty($id) && is_numeric($id)) {
      $data = ModelFactory::getProduct()->getById($id);
      if (!empty($data)) {
        $data->imagePath = CommonHelper::getImageUrl($data->image);
        if (!empty($data->images)) {
          $data->images = json_decode($data->images);
          foreach ($data->images as $value) {
            $images[] = ['imageId' => $value , 'imagePath' => CommonHelper::getImageUrl($value)];
          }
          $data->images = $images;
        }
        $data->form = \Drupal::formBuilder()
          ->getForm('Drupal\shopnew\Form\cart\AddForm' , $data);
      }
    }
    return [
      '#theme'    => 'product_detail' ,
      '#data'     => $data ,
      '#attached' => array(
        'library' => [
          'shopnew/shopnew_assets'
        ] ,
      ) ,
    ];
  }

  /**
   * function get list product
   * @param null $slug
   * @param null $child
   * @return array
   */
  function ListProductByCategory($slug = null , $child = null)
  {
    $data = [];
    if (!empty($child)) {
      $slug = $child;
    }
    if (!empty($slug)) {
      $result = ModelFactory::getCategory()->getBySlug($slug);
      if (!empty($result) && !empty($result->id) && $result->parent_id == 0) {
        $getCategoryChild = ModelFactory::getCategory()->getCateChild($result->id);
        if (!empty($getCategoryChild)) {
          foreach ($getCategoryChild as $cate) {
            $listCateId[] = $cate->id;
          }
        }
        if (!empty($listCateId)) {
          $res = ModelFactory::getProduct()->getByCategory($listCateId);
        }
      } else {
        $res = ModelFactory::getProduct()->getByCategory($result->id);
      }
      if (!empty($res)) {
        $data = CommonHelper::getImagePathProduct($res);
      }
      return [
        '#theme'    => 'list_product_category' ,
        '#data'     => $data ,
        '#attached' => [
          'library' => [
            'shopnew/shopnew_assets'
          ]
        ]
      ];
    }
  }
}
