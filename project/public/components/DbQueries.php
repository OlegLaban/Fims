<?php
class DbQueries
{

  public static function insertQery($data, $tableName)
  {
    $db = Db::getConnection();
    $params = implode(", ",array_keys($data));
    $values = array_values($data);
    $sql = "INSERT INTO {$tableName} VALUES(" .  $params . ")";
    $result  = $db->prepare($sql);
    $resultArr = $result->execute($data);
  }

  public static function selectQuery($data, $tableName)
  {
    $db = Db::getConnection();
    if($data === '*'){
      $sql = "SELECT * FROM {$tableName}";
      $result = $db->query($sql);
      $resultArr = $result->fetchAll(PDO::FETCH_ASSOC);
      return $resultArr;
    }else if(is_array($data)){
      $params = implode(", ",array_keys($data));
      $values = array_values($data);
      $sql = "SELECT {$params} FROM {$tableName}";
      $result = $db->prepare($sql);
      $result->execute($data);
      $resultArr = $result->fetchAll(PDO::FETCH_ASSOC);
      return $resultArr;
    }


  }
}

?>
