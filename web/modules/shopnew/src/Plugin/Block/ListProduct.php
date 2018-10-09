<?php
/**
 * Created by PhpStorm.
 * User: lehoangvinh
 * Date: 9/27/2018
 * Time: 4:29 PM
 */

namespace Drupal\shopnew\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\file\Entity\File;
use Drupal\shopnew\Helper\Services;
use Drupal\shopnew\Model\CategoryModel;
use Drupal\shopnew\Model\ModelFactory;
use Drupal\shopnew\Model\ProductModel;
use http\Url;

/**
 * Provides a 'Hello' Block.
 *
 * @Block(
 *   id = "list_product",
 *   admin_label = @Translation("shop_new_list_product"),
 *   category = @Translation("shop_new_list_product"),
 * )
 */
class ListProduct extends BlockBase
{
  /**
   * {@inheritdoc}
   */

  public function build()
  {
    $category = ModelFactory::getCategory();
    $cateParent = $category->getParentId();
    $product = ModelFactory::getProduct();
    $res = $product->getAll();
    $res = array_map(function ($value) {
      $file = File::load($value->image);
      if ($file) {
        $value->imagePath = file_create_url(File::load($value->image)->getFileUri());
        $value->url = \Drupal\Core\Url::fromRoute('shopnew.detail' , ['id' => $value->id , 'slug' => $value->slug])->toString();
        $value->price = isset($value->price) ? number_format($value->price , 0 , ',' , '.') : '';
      } else {
        $value->imagePath = '';
      }
      return $value;
    } , $res);
    return array(
      '#theme'    => 'block_shop_new_list' ,
      '#data'     => $res ,
      '#attached' => [
        'library' => [
          'shopnew/shopnew_assets'
        ]
      ]
    );
  }

}
