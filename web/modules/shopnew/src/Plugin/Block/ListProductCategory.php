<?php
/**
 * Created by PhpStorm.
 * User: lehoangvinh
 * Date: 10/1/2018
 * Time: 5:08 PM
 */

namespace Drupal\shopnew\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\shopnew\Helper\CommonHelper;
use Drupal\shopnew\Model\ModelFactory;

/**
 * Provides a 'Hello' Block.
 *
 * @Block(
 *   id = "ListProductCategory",
 *   admin_label = @Translation("shop_new_list_product_category"),
 *   category = @Translation("shop_new_list_product_category"),
 * )
 */
class ListProductCategory extends BlockBase
{
  function build()
  {
    // TODO: Implement build() method.
    $currentPath = \Drupal::service('path.current')->getPath();
    $slug = \Drupal::service('path.alias_manager')->getAliasByPath($currentPath);
    $slug = explode('/' , $slug);
    if (!empty($slug)) {
      $category = ModelFactory::getCategory();
      $product = ModelFactory::getProduct();
      $result = $category->getBySlug($slug[1]);
      if (!empty($result) && !empty($result->id) && $result->parent_id == 0) {
        $getCategoryChild = $category->getCateChild($result->id);
        if (!empty($getCategoryChild)) {
          foreach ($getCategoryChild as $cate) {
            $listCateId[] = $cate->id;
          }
        }
        if (!empty($listCateId)) {
          $res = $product->getByCategory($listCateId);
        } else {
          $res = $product->getByCategory($result->id);
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
}
