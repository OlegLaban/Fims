<?php

class Users
{
    public static function getAllUsersAndFirmsWithPage($page, $count = Config::COUNT_NOTES_ON_PAGE)
    {
        $count = intval($count);
        $page = intval($page);
        $offset = ($page - 1) * $count;
        $sql = "SELECT firms_users.id_firm, firms_users.id_user, firms.firm_name, users.data_start_job AS date, "
                ." users.first_name, users.Last_name, birthd_day FROM `firms_users` INNER JOIN `firms` "
                . " ON (firms.id_firm = firms_users.id_firm) INNER JOIN `users` ON (users.id_user = firms_users.id_user)"
                ." LIMIT {$count} OFFSET {$offset} ";
        return DbQuery::otherOuery($sql, true);


    }

    public static function getFilterUserWithPage($page, $data, $count = Config::COUNT_NOTES_ON_PAGE)
    {
        $count = intval($count);
        $page = intval($page);
        $offset = ($page - 1) * $count;
        $sql = self::prepareStrQuerFiltUser($data);
        $countUser = self::countUsersWithFilter($sql);
        $sql .= " LIMIT {$count} OFFSET {$offset} ";
        $resultArr = DbQuery::otherOuery($sql, true);
        $resultArr['count'] =   $countUser['count'];
        return $resultArr;
    }


    public static function countUsers()
    {
        return DbQuery::getOtherData("COUNT(`id_firm`) AS `count`", "firms_users");
    }

    public static function countUsersWithFilter($sql){
        $num = strpos($sql, "F");
        $sql = substr($sql, $num);
        $sqlCount = "SELECT COUNT(*) AS `count` " . $sql;
        return DbQuery::otherOuery($sqlCount);
    }

    public static function getLastAddUsers($count)
    {
        $sql = "SELECT firms_users.id_firm, firms_users.id_user, firms.firm_name, users.data_start_job AS date, "
            ." users.first_name, users.Last_name, users.birthd_day FROM `firms_users` INNER JOIN `firms` "
            . " ON (firms.id_firm = firms_users.id_firm) INNER JOIN `users` ON (users.id_user = firms_users.id_user)"
            . " ORDER BY `id_user` DESC LIMIT {$count}";
        return DbQuery::otherOuery($sql, true);
    }

    public static function prepareStrQuerFiltUser($data)
    {
        $sql = "SELECT firms_users.id_firm, firms_users.id_user, firms.firm_name, users.data_start_job AS date, "
            ." users.first_name, users.Last_name, users.birthd_day FROM `firms_users` INNER JOIN `firms` "
            . " ON (firms.id_firm = firms_users.id_firm) INNER JOIN `users` ON (users.id_user = firms_users.id_user)";
        $count = 0;
        foreach ($data as $key => $item){
            if($data['literaDo'] != '' || $data['literaOt'] != ''){
                if($key == 'literaOt' || $key == 'literaDo'){
                    $count++;
                    if($key == 'literaOt'){
                        $sql .= " WHERE (`Last_name`  BETWEEN  '" . trim($item) . "%' ";
                    }else if($key == 'literaDo'){
                        $sql .= " AND  '" . trim($item) . "%') ";
                    }else if(!isset($data['literaDo'])){
                        $sql .= " ) ";
                    }
                }
            }
            if(isset($data['company'])){
                if($key == 'company' && $count == 0){
                    $count++;
                    $sql .= " WHERE ( firms.id_firm IN (" ."'" . implode("','", $item) ."'" . ")) ";
                }else if($count >= 1 && $key =='company'){
                    $count++;
                    $sql .= "  AND ( firms.id_firm IN (" . "'". implode("','", $item) . "'" . ")) ";
                }
            }

            if(($data['dateOt'] != '' || $data['dateDo'] != '') && ($key == 'dateOt' || $key == 'dateDo')){
                if($data['dateOt'] != '' && $key == 'dateOt'){
                    if($count == 0){
                        $count++;
                        $sql .= " WHERE ( `birthd_day` BETWEEN " . Other::toUnixTime($item) . " ";
                    }else if($count >= 1){
                        $count++;
                        $sql .= " AND (`birthd_day` BETWEEN " . Other::toUnixTime($item) . " ";
                    }

                }else if($data['dateOt'] == '' && $key == 'dateOt'){
                    if($count == 0){
                        $count++;
                        $sql .= " WHERE (`birthd_day` BETWEEN  (SELECT MIN(`birthd_day`) FROM `users`) ";
                    }else if($count >= 1){
                        $count++;
                        $sql .= " AND (`birthd_day` BETWEEN  (SELECT MIN(`birthd_day`) FROM `users`) ";
                    }
                }
                if($data['dateDo'] != '' && $key == 'dateDo'){
                        $sql .= " AND " . Other::toUnixTime($item) . ") ";
                }else if($data['dateDo'] == '' && $key == 'dateDo'){
                        $sql .= " AND  " . Other::toUnixTime(date("Y.m.d")) . ") ";
                }
            }

        }
        return $sql;
    }


}