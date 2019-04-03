<?php


class Admin
{
    public static function addNewCompany($data)
    {
        $arr = [
            'id_firm' => NULL,
            'firm_name' => $data['firm_name'],
            'ogrn' =>  (int) $data['ogrn'],
            'oktmo' => (int) $data['oktmo'],
            'description' => $data['description'],
            'logo' => $_POST['logo']
        ];
        $arrWithData = DbQuery::prepareDataForQuery($arr);
        $sql = "INSERT INTO `firms` ({$arrWithData['cols']})  VALUES({$arrWithData['placeholders']})";
        DbQuery::otherOuery($sql, true, false,  $arrWithData['arrForExec'], false);
    }

    public static function addNewWorker($data)
    {
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
        $arrWithData = DbQuery::prepareDataForQuery($arr);

        $sql = "START transaction;
            INSERT INTO `users` ({$arrWithData['cols']}) VALUES({$arrWithData['placeholders']});
            INSERT INTO `firms_users` (`id_user`, `id_firm`) VALUES( (SELECT MAX(`id_user`) FROM `users`), {$data['id_firm']});
            COMMIT;
            ";
        DbQuery::otherOuery($sql, true, false, $arrWithData['arrForExec'], false);

    }

}