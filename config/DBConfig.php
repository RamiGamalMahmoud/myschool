<?php

namespace config;

use Simple\Core\DataAccess\IDBConfig;

class DBConfig implements IDBConfig
{
  private const DB_NAME   = 'school_management';
  private const DRIVER   = 'mysql';
  private const HOST     = 'localhost';
  private const PASSWORD = '1234';
  private const PORT     = 3306;
  private const USER_NAME = 'rami';

  public static function getConnectionString(): string
  {
    return self::DRIVER . ':host=' . self::HOST . ';dbname=' . self::DB_NAME;
  }

  public static function getOptinos(): array
  {
    return [];
  }

  public static function getUserName(): string
  {
    return self::USER_NAME;
  }

  public static function getPassword(): string
  {
    return self::PASSWORD;
  }

  public static function getPort(): int
  {
    return self::PORT;
  }
}
