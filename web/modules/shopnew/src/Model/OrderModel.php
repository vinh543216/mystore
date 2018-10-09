<?php
/**
 * Created by PhpStorm.
 * User: lehoangvinh
 * Date: 10/1/2018
 * Time: 11:29 AM
 */

namespace Drupal\shopnew\Model;
class OrderModel extends ModelBase
{
  const TABLE = 'shopnew_order';

  function __construct()
  {
    parent::__construct();
  }

  function save($data = [])
  {
    // TODO: Implement save() method.
    $fields = array_keys($data);
    //    $txn = $this->connection->startTransaction();
    try {
      $result = $this->connection->insert(self::TABLE)
        ->fields($fields)
        ->values($data)->execute();
      return $result;
    } catch (\Exception $e) {
      //      $txn->rollBack();
      \Drupal::logger('type')->error($e->getMessage());
    }
  }

  function edit($field , $id)
  {
    // TODO: Implement edit() method.
  }

  function delete($id)
  {
    // TODO: Implement delelte() method.
  }

  function getAll()
  {
    // TODO: Implement getAll() method.
  }
}
