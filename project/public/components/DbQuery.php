<?php
/**
 * Created by PhpStorm.
 * User: gelo
 * Date: 26.3.19
 * Time: 10.14
 */

class DbQuery
{

    public static function getAllData($table, $where = null)
    {
       $db = Db::getConnection();
       if($where != null){
           $placeholders = trim(self::prepareStrQuery(array_keys($where),true));
           $values = trim(self::prepareStrQuery(array_values($where)));
           $resultStr = self::preStrQueForWhereOrIns(array_keys($where), explode(" ", $placeholders), true);
           $resultArrExec = self::preStrQueForWhereOrIns(explode(" ", $placeholders), explode(" ", $values));
           $result = $db->prepare("SELECT * FROM " . $table . " WHERE " . $resultStr);
           $result->execute($resultArrExec);
       }else{
           $result = $db->query("SELECT * FROM " . $table);
       }
        return $result->fetchAll(PDO::FETCH_ASSOC);

    }

    public static function getAllDataWithPage($table, $page, $where = null, $count = Config::COUNT_NOTES_ON_PAGE)
    {
        $db = Db::getConnection();
        $count = intval($count);
        $page = intval($page);
        $offset = ($page - 1) * $count;
        if($where != null){
            $placeholders = trim(self::prepareStrQuery(array_keys($where),true));
            $values = trim(self::prepareStrQuery(array_values($where)));
            $resultStr = self::preStrQueForWhereOrIns(array_keys($where), explode(" ", $placeholders), true);
            $resultArrExec = self::preStrQueForWhereOrIns(explode(" ", $placeholders), explode(" ", $values));
            $result = $db->prepare("SELECT * FROM {$table} WHERE  {$resultStr} LIMIT {$count} OFFSET {$offset}");
            $result->execute($resultArrExec);
        }else{
            $result = $db->query("SELECT * FROM {$table}  LIMIT {$count} OFFSET {$offset}");
        }
        return $result->fetchAll(PDO::FETCH_ASSOC);

    }

    public static function otherOuery($sql, $bool = false, $razdel = null, $data = null)
    {
        $db  = Db::getConnection();
        if($razdel == null){
            $result = $db->prepare($sql);
            $result->execute();
            if($bool){
                return $result->fetchAll(PDO::FETCH_ASSOC);
            }else{
                return $result->fetch();
            }
        }


    }

    public static function getOtherData($cols, $table, $where = null, $bool = false)
    {
        /*
         * Описание параметров $cols - колонки которые нужно взять, $table - имя таблицы из которой мы будем брать
         * значения, $were блок условий, $bool - эта переменная выбора нужен ли fetchAll (по умолчанию используется fetch)
         * */
        $db = Db::getConnection();
        if($where != null){
            $placeholders = trim(self::prepareStrQuery(array_keys($where), true));
            $values = trim(self::prepareStrQuery(array_values($where)));
            $resultStr = self::preStrQueForWhereOrIns(array_keys($where), explode(" ", $placeholders), true);
            $resultArrExec = self::preStrQueForWhereOrIns(explode(" ", $placeholders), explode(" ", $values));
            $result = $db->prepare("SELECT {$cols} FROM {$table} WHERE {$resultStr}");
            $result->execute($resultArrExec);
        }else{
            $result = $db->query("SELECT {$cols} FROM {$table}");
        }
        if($bool){
            return $result->fetchAll(PDO::FETCH_ASSOC);
        }else{
            return $result->fetch(PDO::FETCH_ASSOC);
        }

    }

    public static function prepareStrQuery($arr, $bool = false)
    {
        $result  = "";
        for ($i = 0; $i < count($arr); $i++){
            if($bool){
                $result .= ":" . $arr[$i] . " ";
            }else{
                $result .= $arr[$i] . " ";
            }
        }
        return $result;
    }

    public static function preStrQueForWhereOrIns($arrKey, $arrPlaceholders, $bool = false, $forInsert = false)
    {

       if($bool){
           $result = "";
       }else{
           $result = [];
       }
       if( count($arrKey) == count($arrPlaceholders)){
                $count = count($arrKey) - 1;
                if($bool){
                    if($forInsert){
                        $result = "( ";
                        for ($i = 0; $i <= $count; $i++){
                            if($i == $count - 1){
                                $result .= " " . $arrKey[$i];
                            }else{
                                $result .= " " . $arrKey[$i] . ",";
                            }
                        }
                        $result .= " )";
                        $result .= " VALUES( ";
                        for ($i = 0; $i <= $count; $i++) {
                            if($i == $count){
                                $result .= " " . $arrPlaceholders[$i];
                            }else{
                                $result .= " " . $arrPlaceholders[$i] . ",";
                            }
                        }
                    }else{
                        for ($i = 0; $i <= $count; $i++) {
                            if($i == $count){
                                $result = $arrKey[$i] . " = " . $arrPlaceholders[$i];
                            }else{
                                $result = $arrKey[$i] . " = " . $arrPlaceholders[$i] . ",";
                            }
                        }
                    }
                }else{
                    for ($i = 0; $i < $count; $i++) {
                        $result[$arrKey[$i]] = $arrPlaceholders[$i];
                    }
                }
            return $result;
        }else{
            die("Длина массивов не одинаковая!");
        }
    }

}