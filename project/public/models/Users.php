<?php

class Users
{
    public static function getUserById($id)
    {
        $id = (int) $id;
        $sql = "SELECT users.id_user, users.last_name, users.birthd_day, users.cnils, users.father_name, users.first_name,
                users.inn, users.photo, users.data_start_job, firms_users.id_firm
                FROM `users` INNER JOIN `firms_users`
                ON (users.id_user = firms_users.id_user) 
                WHERE users.id_user = {$id}";
        return DbQuery::otherOuery($sql);
    }

    public static function getAllUsersAndFirmsWithPage($page, $count = Config::COUNT_NOTES_ON_PAGE)
    {
        $count = intval($count);
        $page = intval($page);
        $offset = ($page - 1) * $count;
        $sql = "SELECT firms_users.id_firm, firms_users.id_user, firms.firm_name, users.data_start_job AS date, "
                ." users.first_name, users.photo, users.Last_name, birthd_day FROM `firms_users` INNER JOIN `firms` "
                . " ON (firms.id_firm = firms_users.id_firm) INNER JOIN `users` ON (users.id_user = firms_users.id_user)"
                ." LIMIT {$count} OFFSET {$offset} ";
        return DbQuery::otherOuery($sql, true);


    }

    public static function getFilterUserWithPage($page, $data, $count = Config::COUNT_NOTES_ON_PAGE)
    {
        $count = intval($count);
        $page = intval($page);
        $page = $page == 0 ? 1 : $page;
        $offset = ($page - 1) * $count;
        $sql = self::prepareStrQuerFiltUser($data);
        $countUser = self::countUsersWithFilter($sql);
        $sql .= " ORDER BY users.Last_name ASC ";
        $sql .= " LIMIT {$count} OFFSET {$offset} ";
        $resultArr = DbQuery::otherOuery($sql, true);
        $resultArr['count'] =   $countUser[0]['count'];
        return $resultArr;
    }


    public static function countUsers()
    {
        $sql = "SELECT COUNT(`id_user`) AS `count` FROM `users`";
        return DbQuery::otherOuery($sql);
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
            ." users.first_name,  users.Last_name, users.birthd_day FROM `firms_users` INNER JOIN `firms` "
            . " ON (firms.id_firm = firms_users.id_firm) INNER JOIN `users` ON (users.id_user = firms_users.id_user)"
            . " ORDER BY `id_user` DESC LIMIT {$count}";
        return DbQuery::otherOuery($sql, true);
    }

    public static function prepareStrQuerFiltUser($data)
    {
        $sql = "SELECT firms_users.id_firm, firms_users.id_user, firms.firm_name, users.data_start_job AS date, "
            ." users.first_name, users.photo, users.Last_name, users.birthd_day FROM `firms_users` INNER JOIN `firms` "
            . " ON (firms.id_firm = firms_users.id_firm) INNER JOIN `users` ON (users.id_user = firms_users.id_user)";
        $count = 0;

        if($data['literaOt'] != ''){
            $litera = $data['literaOt'];
        }else if($data['literaDo'] != ''){
            $litera = $data['literaDo'];
        }
        foreach ($data as $key => $item){
            if($data['literaDo'] != '' || $data['literaOt'] != ''){
                if($key == 'literaOt' || $key == 'literaDo'){
                    $count++;
                    if($data['literaOt'] == ''){
                        $sql .= "WHERE (`Last_name` BETWEEN '" . Other::FirstOrLastLitera($litera, true) . "%' ";
                    }else if($key == 'literaOt'){
                        $sql .= " WHERE (`Last_name`  BETWEEN  '" . trim($item) . "%' ";
                    }else  if($data['literaDo'] == ''){
                        $sql .= " AND '" .  Other::FirstOrLastLitera($litera) . "%' ) ";
                    }else if($key == 'literaDo'){
                        $sql .= " AND  '" . trim($item) . "%') ";
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