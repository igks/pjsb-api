<?php

namespace App\Enums;

abstract class Enums
{
  public static function getArray()
  {
    $result = [];
    foreach (static::getList() as $arr) {

      $result[] = ['id' => $arr, 'value' => static::getString($arr)];
    }
    return $result;
  }
}
