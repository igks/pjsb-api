<?php

namespace App\Enums;

class RoleEnum extends Enums
{
  const ADMIN = 0;
  const CREATOR = 1;
  const STUDENT = 2;

  public static function getList()
  {
    return [
      self::ADMIN,
      self::CREATOR,
      self::STUDENT
    ];
  }

  public static function getString($val)
  {
    switch ($val) {
      case self::ADMIN:
        return "Admin";
      case self::CREATOR:
        return "Content Creator";
      case self::STUDENT:
        return "Siswa";
    }
  }

  public static function getValue($str)
  {
    switch (strtolower($str)) {
      case 'admin':
        return self::ADMIN;
      case 'content creator':
        return self::CREATOR;
      case 'siswa':
        return self::STUDENT;
    }
  }
}
