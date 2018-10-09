<?php

namespace Drupal\shopnew\Helper;

use Drupal\file\Entity\File;

class CommonHelper
{

  static function cateParent($data , $parent = 0 , $str = '--' , $select = 0)
  {
    $result = [];
    foreach ($data as $key => $val) {
      $id = $val->id;
      $name = $val->title;
      if ($val->parent_id == $parent) {
        echo "<option value='$id'>$str $name</option>";

        self::cateParent($data , $id , $str . '--' , $select);

      }
    }
    return $result;
  }

  static function getImageUrl($image)
  {
    $file = File::load($image);
    if ($file) {
      return file_create_url(File::load($image)->getFileUri());
    } else {
      return file_create_url('sites/default/files/my_files/default.jpg');
    }
  }

  static function getImagePathProduct($records = [])
  {
    $data = array_map(function ($value) {
      $file = File::load($value->image);
      if ($file) {
        $value->imagePath = file_create_url(File::load($value->image)->getFileUri());
        $value->url = \Drupal\Core\Url::fromRoute('shopnew.detail' , ['id' => $value->id , 'slug' => $value->slug])->toString();
        $value->price = isset($value->price) ? number_format($value->price , 0 , ',' , '.') : '';
      } else {
        $value->imagePath = '';
      }
      return $value;
    } , $records);
    return $data;
  }

  static function addFileUsage($file)
  {
    $bgfile = File::load($file);
    $file_usage = \Drupal::service('file.usage');
    if (gettype($bgfile) == 'object') {
      $bgfile->setPermanent();
      $bgfile->save();
      $file_usage->add($bgfile , 'shopnew' , 'file' , $file);
    }
  }

  static function deleteFileUsage($file)
  {
    $bgfile = File::load($file);
    $file_usage = \Drupal::service('file.usage');
    if (gettype($bgfile) == 'object') {
      $bgfile->setPermanent();
      $bgfile->save();
      $file_usage->add($bgfile , 'shopnew' , 'file' , $file);
    }
  }
}
