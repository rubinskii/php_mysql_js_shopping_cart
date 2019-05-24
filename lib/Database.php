<?php
class Database {
  protected $pdo = null;
  protected $stmt = null;
  public $error = "";
  public $last_id = null;

  function __construct()
  {
    try
    {
      $str = "mysql:host=" . DB_HOST . ";charset=" . DB_CHARSET;
      if (defined('DB_NAME')) { $str .= ";dbname=" . DB_NAME; }
      $this->pdo = new PDO(
        $str, DB_USER, DB_PASSWORD, [
          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
          PDO::ATTR_EMULATE_PREPARES => false
        ]
      );
      return true;
    }
    catch (PDOException $ex)
    {
      print_r($ex);
      die();
    }
  }

  function exec($sql, $data=null)
  {
    //* выполняет INSERT
    /*
      параметры:
      $sql - запрос, $data - массив данных
    */
 
    try
    {
      $this->stmt = $this->pdo->prepare($sql);
      $this->stmt->execute($data);
      $this->last_id = $this->pdo->lastInsertId();
    }
    catch (PDOException $ex)
    {
      $this->error = $ex;
      return false;
    }
    $this->stmt = null;
    return true;
  }

  function fetch($sql, $cond = null, $key = null)
  {
    //* выполняет запрос SELECT
    /*
      параметры:
      $sql -запрос
      $cond - массив условий
      $key -опционально, сортирует в порядке ключ/данные
    */
    $result = false;
    try
    {
      $this->stmt = $this->pdo->prepare($sql);
      $this->stmt->execute($cond);
      if (isset($key))
      {
        $result = [];
        while ($row = $this->stmt->fetch())
        {
          $result[$row[$key]] = $row;
        }
      }
    }
    catch (PDOException $ex)
    {
      $this->error = $ex;
      return false;
    }
    $this->stmt = null;
    return $result;
  }
}