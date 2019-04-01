<?php
/**
 * Created by PhpStorm.
 * User: gelo
 * Date: 26.3.19
 * Time: 10.14
 */

class DbQuery
{
    public static function perepareStrAllDataWithWhere($db, $table, $where = null, $cols = null)
    {
        /*
         * Описание параметров:
         * "$table" - это имя таблицы из которой будут браться данные
         * "$where" - это массив с условиями. Массив типа {название_столбца => значение} при помощи этого массива
         * будут сформированы placeholders  {:название_столбца} и они вместе с значениями будут подставлены в sql запрос*/

        if(!empty($table)){
            //Проверяем была ли передана перменная и является ли она массивом.
            if($where != null && is_array($where)){
                // В данную переменную мы помещаем подготовленные функцией prepareStrQuery массив placeholders для sql запроса.
                $placeholders = trim(self::prepareStrQuery(array_keys($where),true));
                // В эту переменную мы кладем результируюзий sql запрос с placeholders.
                $resultWhereStr = self::preStrQueForWhereOrIns(array_keys($where), $placeholders, true);
                //В данную переменную мы кладем массив типа {":placeholders" => value} который мы передадим функции execute.
                $resultArrExec = self::preStrQueForWhereOrIns($placeholders, array_values($where));
               // Проверяем были ли переданы нам столбцы елси же нет то берем все, что есть в таблице.
                if($cols == null){
                    //Подготавливаем запрос
                    $result = $db->prepare("SELECT * FROM " . $table . " WHERE " . $resultWhereStr);
                    //Подставляем в строку запроса значения placeholders при помощи массива с ними.
                    return $result->execute($resultArrExec);
                }else{
                    //Подготавливаем запрос
                    $result = $db->prepare("SELECT {$cols} FROM {$table} WHERE {$resultWhereStr}");
                    //Подставляем в строку запроса значения placeholders при помощи массива с ними.
                    return $result->execute($resultArrExec);
                }
            }
        }

    }

    public static function getAllData($table, $where = null)
    {
        $db = Db::getConnection();
        if($where != null){
            $result = self::perepareStrAllDataWithWhere($db, $where);
        }else{
            //В случае если переменная "where" не являтся массивом то выполняется запрос без условий.
            $result = $db->query("SELECT * FROM " . $table);
        }

       //Возвращаем значение полученное из базы данных.
        return $result->fetchAll(PDO::FETCH_ASSOC);

    }

    public static function getAllDataWithPage($table, $offset, $count, $where = null)
    {
        if(!empty($table)){
            //Устанавливаем соединение с базой.
            $db = Db::getConnection();
            // Проверяем была ли передана переменная "where" и является ли она массивом.
            if($where != null && is_array($where)){
                // В данную переменную мы помещаем подготовленные функцией prepareStrQuery массив placeholders для sql запроса.
                $placeholders = trim(self::prepareStrQuery(array_keys($where),true));
                // В эту переменную мы кладем результируюзий sql запрос с placeholders.
                $resultWhereStr = self::preStrQueForWhereOrIns(array_keys($where),  $placeholders, true);
                //В данную переменную мы кладем массив типа {":placeholders" => value} который мы передадим функции execute.
                $resultArrExec = self::preStrQueForWhereOrIns($placeholders, implode(",", array_values($where)));
                //Подготавливаем запрос
                $result = $db->prepare("SELECT * AS `count` FROM {$table} WHERE  {$resultWhereStr} LIMIT {$count} OFFSET {$offset}");
                //Подставляем в строку запроса значения placeholders при помощи массива с ними.
                $result->execute($resultArrExec);
            }else{
                //Просто выполняем запрос в случае если не была передана переменная where
                $result = $db->query("SELECT * FROM {$table}  LIMIT {$count} OFFSET {$offset}");
            }
            //Возвращаем результат запроса.
            return $result->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    public static function otherOuery($sql, $bool = false, $coloumnBool = false, $razdel = null)
    {
         //Устанавливаем соединение с базой данных
        $db  = Db::getConnection();
        //Подготавливаем запрос
        $result = $db->prepare($sql);
        //Выполняем запрос.
        $result->execute();
        /*Проверяем значение булевской переменной.
        В зависимоти от true/false буедет использоваться разные методы fetch: fetchAll/fetch соответсвенно.*/
        if($bool){
            /*Проверяем значение булевской переменной.
        В зависимоти от true/false буедет использоваться разные методы fetch: FETCH_COLUMN/FETCH_ASSOC соответсвенно.*/
           if($coloumnBool){
               return $result->fetchAll(PDO::FETCH_COLUMN, 0);
           }else{
               return $result->fetchAll(PDO::FETCH_ASSOC);
           }

        }else{
            /*Проверяем значение булевской переменной.
        В зависимоти от true/false буедет использоваться разные методы fetch: FETCH_COLUMN/FETCH_ASSOC соответсвенно.*/
            if($coloumnBool){
               return $result->fetch(PDO::FETCH_COLUMN, 0);
            }else{
               return $result->fetch(PDO::FETCH_ASSOC);
            }
        }
    }

    public static function getOtherData($cols, $table, $where = null, $bool = false)
    {
        //Данная функция выполняет произвольный запрос собирая его из параметров кторое в нее передаются.
        /*
         * Описание параметров $cols - колонки которые нужно взять, $table - имя таблицы из которой мы будем брать
         * значения, $were блок условий, $bool - эта переменная выбора нужен ли fetchAll (по умолчанию используется fetch)
         * */
        //Устанавливаем соединение с базой.
        $db = Db::getConnection();
        //Проверяем была ли передана переменная "where"
        if($where != null){
            //Присваем переменной результат работы соответсвующей функции.
            $result = self::perepareStrAllDataWithWhere($db, $table, $where, $cols);
        }else{
            //В случае если переменная "where" не была передана просто выполняем запрос с подстановкой остальных значений.
            $result = $db->query("SELECT {$cols} FROM {$table}");
        }
        /*Проверяем значение булевской переменной.
        В зависимоти от true/false буедет использоваться разные методы fetch: fetchAll/fetch соответсвенно.*/
        if($bool){
            return $result->fetchAll(PDO::FETCH_ASSOC);
        }else{
            return $result->fetch(PDO::FETCH_ASSOC);
        }

    }

    public static function prepareStrQuery($arr, $bool = false)
    {
        // Данная функция собирает из массива строку c placeholders для подготовленного запроса.
        /*Проверяем значение булевской переменной.
       В зависимоти от true/false буедет placeholders будут без запятых и с ними..*/
        if($bool){
            $result = ":" . implode(" ", $arr);
        }else{
            $result = ":" . implode(",", $arr);
        }
       return $result;
    }

    public static function preStrQueForWhereOrIns($key, $value, $bool = false, $forInsert = false)
    {
      //Данная функция подготавливает часть sql запроса для блока WHERE или INSERT. В зависимости от выбранных
      // параметров а именно переменной "forInsert".
      // Также в нее входит подготовка массива для метода PDO::execute($array).
        // Данным условием проверяется что мы хотим получить - строку для запроса или массив для execute().
       if($bool){
           //Если нам нужна строка то определяем переменную result как пустую строку.
           $result = "";
       }else{
           //Если нам нужен массив то определяем переменную result как пустой массив.
           $result = [];
       }
       //Проверяем совпадает ли  количество столбцов с количеством placeholders
        $arrCols = explode(" ", $key);
                //Находим колличество значений в массивах
                $count = count($arrCols) - 1;
                //Переходим к созданию строки или массива в зависимости от "bool".
                if($bool){
                    //В этом условном операторе проверяем для какого блока готовим строку для INSERT или для WHERE.
                    if($forInsert){
                        //Формируем часть строки со столбцами.
                        $result .= " ( " .  $key . " ) ";
                        //Формируем часть строки со значениями.
                        $result .= " VALUES( " . implode(",", $value) . " ) ";
                    }else{
                        //Формируем строку для блока WHERE
                        $result .= $arrCols;
                    }
                }else{
                    for ($i = 0; $i < $count; $i++) {
                        $result[$arrCols[$i]] = $value[$i];
                    }
                }
            return $result;
    }

}