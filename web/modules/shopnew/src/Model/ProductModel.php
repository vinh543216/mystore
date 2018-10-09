<?php
/**
 * Created by PhpStorm.
 * User: lehoangvinh
 * Date: 9/28/2018
 * Time: 9:23 AM
 */

namespace Drupal\shopnew\Model;
class ProductModel extends ModelBase
{
  const TABLE = 'shopnew_product';

  function __construct()
  {
    parent::__construct();
  }

  function save($data = [])
  {
    $fields = array_keys($data);
    $txn = $this->connection->startTransaction();
    try {
      $result = $this->connection->insert(self::TABLE)
        ->fields($fields)
        ->values($data)->execute();
      return $result;
    } catch (\Exception $e) {
      $txn->rollBack();
      // Log the exception to watchdog.
      \Drupal::logger('product')->error($e->getMessage());
    }
  }

  function getAll()
  {
    $query = $this->connection->select(self::TABLE , 'sn');
    $query->fields('sn');
    $query->orderBy('id' , 'DESC');
    $pager = $query->extend('Drupal\Core\Database\Query\PagerSelectExtender')->limit(10);
    $rs = $pager->execute()->fetchAll();
    return $rs;
  }

  function searchByParam($condition = [] , $search = [])
  {
    $query = $this->connection->select(self::TABLE , 'prod');
    if (!empty($condition)) {
      foreach ($condition as $key => $value) {
        $query->condition($key , $value);
      }
    }
    if (!empty($search)) {
      foreach ($search as $key => $value) {
        $query->condition($key , '%' . $query->escapeLike($value) . '%' , 'LIKE');
      }
    }
    $query->fields('prod');
    $query->orderBy('id' , 'DESC');
    $pager = $query->extend('Drupal\Core\Database\Query\PagerSelectExtender')->limit(10);
    $rs = $pager->execute()->fetchAll();
    return $rs;
  }

  function getById(int $id)
  {
    $query = $this->connection->select(self::TABLE , 'snc');
    $query->condition('id' , $id);
    $query->fields('snc');
    return $query->execute()->fetchObject();
  }

  function getByCategory($categoryId)
  {
    $query = $this->connection->select(self::TABLE , 'snc');
    if (is_array($categoryId)) {
      $query->condition('category_id' , $categoryId , 'IN');
    } else {
      $query->condition('category_id' , $categoryId);
    }
    $query->fields('snc');
    return $query->execute()->fetchAll();
  }

  function edit($field , $id)
  {
    $this->connection->update(self::TABLE)
      ->fields($field)
      ->condition('id' , $id)
      ->execute();
  }

  function delete($id)
  {
    $query = $this->connection->delete(self::TABLE)
      ->condition('id' , $id)
      ->execute();
    return $query;
  }
}
