<?php
/**
 * Created by PhpStorm.
 * User: lehoangvinh
 * Date: 10/3/2018
 * Time: 11:46 AM
 */

namespace Drupal\shopnew\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'shopnew' Block.
 *
 * @Block(
 *   id = "list_cart",
 *   admin_label = @Translation("shop_new_list_cart"),
 *   category = @Translation("shop_new_list_cart"),
 * )
 */
class ListCart extends BlockBase
{
  function build()
  {
    return [
      '#theme'    => 'block_list_cart' ,
      '#attached' => [
        'library' => [
          'shopnew/shopnew_assets'
        ]
      ]
    ];
  }
}
