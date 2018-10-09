<?php
/**
 * Created by PhpStorm.
 * User: lehoangvinh
 * Date: 9/20/2018
 * Time: 8:59 AM
 */

namespace Drupal\shopnew\Model;
abstract class ModelBase
{
  protected $connection;

  function __construct()
  {
    return $this->connection = \Drupal::database();
  }

  abstract function save();

  abstract function delete($id);

  abstract function edit($filed , $id);

  abstract function getAll();
}
