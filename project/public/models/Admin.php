<?php
class Admin
{

    public static function addNewCompany($data)
    {
        //Массив с данным для запроса в базу (ключи это имена столбцов в таблице, а значения это данные в ячейках)
        $arr = [
            'id_firm' => NULL,
            'firm_name' => $data['firm_name'],
            'ogrn' =>  (int) $data['ogrn'],
            'oktmo' => (int) $data['oktmo'],
            'description' => $data['description'],
            'logo' => $data['logo']
        ];
        //Подготавливаем данные к запросу (вернутся имена столбцов и placeholders)
        $arrWithData = DbQuery::prepareDataForQuery($arr);
        //Подставляем в sql запрос имена столбцов и placeholders
        $sql = "INSERT INTO `firms` ({$arrWithData['cols']})  VALUES({$arrWithData['placeholders']})";
        //Выполненяем запрос
        DbQuery::otherOuery($sql, false, [],  $arrWithData['arrForExec'], false);
    }

    public static function addNewWorker($data)
    {
        //Массив с данным для запроса в базу (ключи это имена столбцов в таблице, а значения это данные в ячейках)
        $arr = [
            'id_user' => NULL,
            'last_name' => $data['last_name'],
            'first_name' => $data['first_name'],
            'father_name' => $data['father_name'],
            'birthd_day' => Other::toUnixTime($data['birthd_day']),
            'inn' => $data['inn'],
            'cnils' => $data['cnils'],
            'photo' => $data['logo'],
            'data_start_job' => Other::toUnixTime($data['data_start_job'])
        ];
        //Подготавливаем данные к запросу (вернутся имена столбцов и placeholders)
        $arrWithData = DbQuery::prepareDataForQuery($arr);
        //Подставляем в sql запрос имена столбцов и placeholders
        $sql = "START transaction;
            INSERT INTO `users` ({$arrWithData['cols']}) VALUES({$arrWithData['placeholders']});
            INSERT INTO `firms_users` (`id_user`, `id_firm`) VALUES( (SELECT MAX(`id_user`) FROM `users`), {$data['id_firm']});
            COMMIT;
            ";
        //Выполненяем запрос
        DbQuery::otherOuery($sql, true, [], $arrWithData['arrForExec'], false);

    }

    public static function Delete($id, $table = [])
    {
        $row = [];
        $row[] = array_keys($table)[0];
        $row[] = $table[reset($row)];
        unset($table[$row[0]]);
        $sql = "
            START transaction;
                DELETE FROM " . array_shift($table) .  " WHERE `" . reset($row) ."` = :" . reset($row) .";
                DELETE FROM " . array_shift($table) . " WHERE `" . reset($row) ."` = :" . reset($row) .";
            COMMIT; 
        ";
        $row[0] = ":" . $row[0];
        $data = [
            $row[0] => $row[1]
        ];
        DbQuery::otherOuery($sql, false, $data, []);
    }

    public static function UploadFile($localFileName, $localPath = '/upload/')
    {
        $errors = [];
        $maxSize = 80 * 1024 * 1024;

        //Получаем расширение файла.
        $ext = pathinfo($_FILES['filename']['name'], PATHINFO_EXTENSION);

        $pathInfo = pathinfo($localFileName);
        if($ext != $pathInfo['extension']) $errors[] = "Неверное расширение файла!";

        $newFileName = $pathInfo['filename'] . '_' . time() . '_.' . $pathInfo['extension'];

        if($_FILES['filename']['size'] > $maxSize){
            $errors[] = "Размер файла превышает допустимое значение!";
        }
        if(empty($errors)){
            $path = ROOT . $localPath;

            if(! file_exists($path)){
                mkdir($path);
            }

            if(is_uploaded_file($_FILES['filename']['tmp_name'])){
                $res  = move_uploaded_file($_FILES['filename']['tmp_name'], $path . $newFileName);
                return ($res == true) ? $newFileName : false;
            }else{
                return false;
            }
        }else{
            return $errors;
        }

    }

    public static function parserXmlFile($pathToFile, $arrValuesWorker, $arrValuesCompany)
    {
        //Генерируем путь к файлу.
        $pathFile = ROOT . '/upload/' . $pathToFile;
        $line = fopen($pathFile, "r");
        //Итератор для подсчета номера строки файла
        $i = 0;
        //Получаем массив со строкой файла и номером строки
        $fileDataArr = self::getStrOnFile($line, $i);
        $bool = false;
        //Объявляем строку в которой будем хранить
        $xmlStr = '';
            foreach ($fileDataArr as $arrItem){
                //Достаем строку файла для дальнейшей обработки.
                $item =  array_shift($arrItem);
                //Достаем номер строки для дальнейшей обработки.
                $i = array_shift($arrItem);
                if($item === Config::COMPANIES_NAME_TAG){
                    $parrentTagStart = Config::COMPANIES_PARENT_TAG_START;
                    $parrentTagEnd = Config::COMPANIES_PARENT_TAG_END;
                    $tableName  = Config::TABLE_NAME_COMPANIES;
                    $arrValues = $arrValuesCompany;
                    $bool = true;
                }else if($item === Config::WORKERS_NAME_TAG){
                    $parrentTagStart = Config::WORKERS_PARENT_TAG_START;
                    $parrentTagEnd = Config::WORKERS_PARENT_TAG_END;
                    $tableName = Config::TABLE_NAME_WORKERS;
                    $arrValues = $arrValuesWorker;
                    $bool = true;
                }
                //Проверяем является ли элемент начинающим тэгом
                if(trim($item) == @$parrentTagStart){
                    //Оборачиваем все это в еще один тэг для более удобного последующего переобразования в объект.
                    $xmlStr = '';
                    //Добавляем свойство(формат XML) в строку
                    $xmlStr .= trim($item);
                   //Проверяем является ли элемент начинающим тэгом
                }else if(trim($item) == @$parrentTagEnd){
                    //Добавляем свойство(формат XML) в строку
                    $xmlStr .= trim($item);
                    //Закрываем нашу обертку.
                    $xmlStr .= '';
                    //Проверяем нащу результирующую строку на соответствие формату XML (в случае Возвращает объект)
                    $objectXMLData = self::validXML($xmlStr);
                    //Проверяем Объект на наличие всех обязательных свойств
                    $errors = self::errorsValuesInObj($objectXMLData, $arrValues, $i);
                    self::loggerErrorsToFile($errors, $pathToFile, 'uploads');
                    self::loggerErrorsToDataBase($errors, 'uploads', $pathToFile);
                    //Переобразуем объект в массив.
                     $resultArr = self::XMLDataToArray($objectXMLData, $tableName);
                     //Добавляем имя таблицы в которую нужно поместить
                     $resultArr['table_name'] = $tableName;
                     //Добавляем в базу.
                     Admin::AddToDataBase($resultArr);
                }else{
                    // В случае если нам передан не закрывающий и не открывающий тэги, то просто записываем данные к строке.
                    $xmlStr .= trim($item);
                }
            }
    }





    public static function getStrOnFile($fileOpen, $i = false)
    {
        /* fileOpen - параметр с соединением к открытому файлу
         *  i - инкремент для подсчета строки фалйла.
         * Функция возвращает массив если осуществляется подсчет строк, в простивном случае только  строку.
         */
        while(!feof($fileOpen)){
            if($i !== false){
                $i++;
            }

            if($i){
                yield [trim(fgets($fileOpen)), $i];
            }else{
                yield trim(fgets($fileOpen));
            }


        }
    }

    public static function validXML($strXml)
    {
        /*Проверяем на валидность XML строку
         * В случае успеха возврящаем обект с данными из XML
         * В противном случае возвращаем масиив с ошибками.
         * */
        //Включаем проверку на ощибки
        libxml_use_internal_errors(true);
        //Преобразуем из XML в объект если будут найдены ошибки вернется false
        $sxe = simplexml_load_string($strXml);
        //Объевляем масиив с ошибками
        $errors = [];
        //Если были найдены ошибки записываем в строку.
        if (!$sxe) {
            //Предупреждение о том что были найдены ошибки.
            echo "Failed loading XML\n";
            foreach(libxml_get_errors() as $error) {
                $errors[] =  $error->message;
            }
        }else {
            //Если ошибок нет то возвращаем обект со значениями.
            return $sxe;
        }
        //В противном случае возвращаем масиив с ошибками.
        return $errors;
    }

    public static function XMLDataToArray($objData, $tableName)
    {
        /*
         * Преобразуем объект в массив*/
        //Объеявляем массив в который положим значения.
        $data = [];
        //Перебераем массив и добавляем значения в массив.
        if($tableName == Config::TABLE_NAME_COMPANIES){

                $data['id_firm'] = NULL;
                $data['firm_name'] = htmlspecialchars($objData->firm_name);
                $data['ogrn'] = (int) $objData->ogrn;
                $data['oktmo'] = (int) $objData->oktmo;
                $data['description'] = htmlspecialchars($objData->description);
                $data['logo'] =  isset($objData->logo) ? htmlspecialchars($objData->photo) : 'no_logo.png';

        }elseif($tableName == Config::TABLE_NAME_WORKERS){

                $data['id_user'] = NULL;
                $data['last_name'] = htmlspecialchars($objData->last_name);
                $data['first_name'] = htmlspecialchars($objData->first_name);
                $data['father_name'] = htmlspecialchars($objData->father_name);
                $data['birthd_day'] = htmlspecialchars($objData->birthd_day);
                $data['inn'] =   (int) $objData->inn;
                $data['cnils'] = (int) $objData->cnils;
                $data['photo'] = isset($objData->photo) ?  htmlspecialchars($objData->photo) : 'no_avatar.jpg';
                $data['data_start_job'] = isset($objData->data_start_job) ? (int) $objData->data_start_job : time();

        }

        //Возвращаем массив.
        return $data;
    }

    public static function errorsValuesInObj($obj, $valueName, $i)
    {
        /*Проверяем объект на присутвие обязательных значений
            Описание параметров функций
                * $obj - Объект со значениями.
                * $valueName - массив который содержит названия обязательных тэгов (без скобок и слешов).
        */
        //Массив с ошибками.
        $errors = [];
        //Перебераем массив с обязательными свойствами
        $count  = $i - count($obj) - 1;
        foreach ($valueName as $item){
            //Проверяем присутвует ли данное свойство в объекте. (если нет то добавляем значение в массив).
            if(!property_exists($obj, $item)){
                // $i - count($obj->worker) нужно для того чтобы определить где начинается элемент с тэгами значений
                $errors[] = "Отсутвует значение: " . $item . " в элементе который начинается со строки № " .  $count;
            }
        }
        // Если ощибки присутвуют то возвращаем их.
        if(!empty($errors)){

            return $errors;
        }
    }

    public static function loggerErrorsToFile($errors = [], $filename, $path = "")
    {
        //Проверяем не пустой ли массив с ошибками.
        if(!empty($errors)){
            //Если есть на концах строки с путем слэши - очищаем от них.
            $path = trim($path, "/");
            //То же самое и с именем файла.
            $filename = trim($filename, "/");
            //Убераем от имени файла расщирение.
            $pos = strpos($filename, '.');
            $filename = substr($filename, 0, $pos);
            //Генерируем локальный путь к файлу (пока без самого файла, только папки).
            $pathLocal = 'errors/' . $path;
            //Преобразуем образовавшуюся строку в массив для того чтобы далее поэтапно создавать папки в случае их
            //отсутвия.
            $pathArr  = explode('/', $pathLocal);
            //Генерируем абсолютный путь без имени файла.
            $pathAbsolute = ROOT;
            foreach ($pathArr as $nameFolder){
                $pathAbsolute .= '/' . $nameFolder;
                //Инкрементно проверяем существует ли папка по указаному пути если нет создаем.
                if(! file_exists($pathAbsolute)){
                    mkdir($pathAbsolute);
                }
            }
            //Генерируем абсолютный путь с имененм файла.
            $pathAbsolute  .= '/' . 'LOG_' . $filename . ".txt";
            if(! file_exists($pathAbsolute)){
                //Если файл не существует - создаем.
                $file = fopen($pathAbsolute, 'wa');
            }else{
                //Если существует открываем для редактирования.
                $file = fopen($pathAbsolute, "a");
            }
            //Поинкрементно записываем ошибки в файл.
            foreach ($errors as $item){
                //Добаляем перенос строки.
                $item .= "\n";
                //Производим запись в файл.
                fwrite($file, $item);
            }
            //Закрываем файл.
            fclose($file);
        }
    }

    public static function loggerErrorsToDataBase($errors = [], $operation, $fileName)
    {
        //Проверяем не пустой массив с ошибками
        if(!empty($errors)){
            //Устанавляиваем соединение
            $db = Db::getConnection();
             //Проверяем есть ли таблица для хранения логов в базе данных.
            $tableExit = $db->query("SHOW TABLES LIKE 'errors'");
            //Проверяем существует ли таблица в базе данных
            if($tableExit->fetch() == NULL){
                //Если нет создаем
                $db->query("CREATE TABLE `errors` (
                    `id_log` int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    `name_operation` varchar(256) COLLATE 'utf8_general_ci' NOT NULL,
                    `file_name` varchar(256) COLLATE 'utf8_general_ci' NOT NULL,
                    `date_time` timestamp NOT NULL ON UPDATE CURRENT_TIMESTAMP,
                    `text_message` text COLLATE 'utf8_general_ci' NOT NULL
                    ) COLLATE 'utf8_general_ci'; ");
            }
            //Проходимся по массиву с ошибками
            foreach ($errors as $item){
                //Массив для добавления в базу
                $arr = [
                    'id_log' => NULL,
                    'name_operation' => htmlspecialchars($operation),
                    'file_name' => htmlspecialchars($fileName),
                    'date_time' =>  NULL,
                    'text_message' => htmlspecialchars($item)
                ];
                //Подготавливаем данные к запросу (вернутся имена столбцов и placeholders)
                $arrWithData = DbQuery::prepareDataForQuery($arr);
                //Подставляем в sql запрос имена столбцов и placeholders
                $sql = "INSERT INTO `errors` ({$arrWithData['cols']})  VALUES({$arrWithData['placeholders']})";
                //Выполненяем запрос
                DbQuery::otherOuery($sql, false, $arrWithData['arrForExec'],  false);
            }
        }

    }

    public static function AddToDataBase($data)
    {
        $tableName = array_pop($data);
        $arrWithData = DbQuery::prepareDataForQuery($data);
        //Подставляем в sql запрос имена столбцов и placeholders
        $sql = "INSERT INTO {$tableName} ({$arrWithData['cols']})  VALUES({$arrWithData['placeholders']})";
        //Выполненяем запрос
        DbQuery::otherOuery($sql, false, $arrWithData['arrForExec'],  false);
    }



}