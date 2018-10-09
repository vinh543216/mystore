<?php
/**
 * Created by PhpStorm.
 * User: lehoangvinh
 * Date: 9/20/2018
 * Time: 9:02 AM
 */

namespace Drupal\shopnew\Model;
class CategoryModel extends ModelBase
{
  const TABLE = 'shopnew_category';

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
      \Drupal::logger('type')->error($e->getMessage());
    }
  }

  function getAll()
  {
    $query = $this->connection->select(self::TABLE , 'sn');
    $query->fields('sn' , ['id' , 'title' , 'description' , 'parent_id' , 'created_at']);
    $query->orderBy('id' , 'DESC');
    $pager = $query->extend('Drupal\Core\Database\Query\PagerSelectExtender')->limit(10);
    $rs = $pager->execute()->fetchAll();
    return $rs;
  }

  function searchByParam($condition = [] , $search = [])
  {
    $query = $this->connection->select(self::TABLE , 'sn');
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
    $query->fields('sn');
    $query->orderBy('id' , 'DESC');
    $pager = $query->extend('Drupal\Core\Database\Query\PagerSelectExtender')->limit(10);
    $rs = $pager->execute()->fetchAll();
    return $rs;
  }

  function getById($id)
  {
    $query = $this->connection->select(self::TABLE , 'snc');
    $query->condition('id' , $id);
    $query->fields('snc');
    return $query->execute()->fetchObject();
  }

  function getBySlug($slug)
  {
    $query = $this->connection->select(self::TABLE , 'snc');
    $query->condition('slug' , $slug);
    $query->fields('snc');
    return $query->execute()->fetchObject();
  }

  function getCateChild($parent_id)
  {
    $query = $this->connection->select(self::TABLE , 'snc');
    $query->condition('parent_id' , $parent_id);
    $query->fields('snc');
    return $query->execute()->fetchAll();
  }

  function getIdCateChild($parent_id)
  {
    $query = $this->connection->select(self::TABLE , 'snc');
    $query->condition('parent_id' , $parent_id);
    $query->fields('snc' , ['id']);
    return $query->execute()->fetchAll();
  }

  function getParentId()
  {
    $query = $this->connection->select(self::TABLE , 'snc');
    $query->condition('parent_id' , 0);
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
