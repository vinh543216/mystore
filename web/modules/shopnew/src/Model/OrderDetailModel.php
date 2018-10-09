<?php
/**
 * Created by PhpStorm.
 * User: lehoangvinh
 * Date: 10/5/2018
 * Time: 2:58 PM
 */

namespace Drupal\shopnew\Model;
class OrderDetailModel extends ModelBase
{
  const TABLE = 'shopnew_order_detail';

  function __construct()
  {
    parent::__construct();
  }

  function save($data = [])
  {
    // TODO: Implement save() method.
    $fields = ['order_id' , 'product_id' , 'price' , 'quality'];
    //$txn = $this->connection->startTransaction();
    try {
      $result = $this->connection->insert(self::TABLE)
        ->fields($fields);
      foreach ($data as $record) {
        $result->values($record);
      }
      $result->execute();
      return $result;
    } catch (\Exception $e) {
      //      $txn->rollBack();
      \Drupal::logger('type')->error($e->getMessage());
    }
  }

  function edit($filed , $id)
  {
    // TODO: Implement edit() method.
  }

  function delete($id)
  {
    // TODO: Implement delete() method.
  }

  function getAll()
  {
    // TODO: Implement getAll() method.
  }
}
