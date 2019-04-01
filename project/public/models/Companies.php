<?php
/**
 * Created by PhpStorm.
 * User: gelo
 * Date: 26.3.19
 * Time: 15.37
 */

class Companies
{
    public static function getCompanies($bool = true)
    {
        if($bool){
            $sql = "SELECT * FROM `firms`";
            return DbQuery::otherOuery($sql, true);
        }else{
            $sql = "SELECT * FROM `firms` LIMIT " . Config::COUNT_NOTES_ON_PAGE;
            return DbQuery::otherOuery($sql, true);
        }

    }

    public static function getFirmsName()
    {
        $sql = "SELECT `firm_name` FROM `firms`";
        return  DbQuery::otherOuery($sql, true, true);
    }

    public static function getCompniesWithPage($page, $count = Config::COUNT_NOTES_ON_PAGE)
    {
        $count = intval($count);
        $page = intval($page);
        $offset = ($page - 1) * $count;
        return  DbQuery::getAllDataWithPage('firms',  $offset, $count);
    }

    public static function getCompaniesFilterWithPage($page, $data, $count = Config::COUNT_NOTES_ON_PAGE)
    {
        $count = intval($count);
        $page = intval($page);
        $offset = ($page - 1) * $count;
        $sql = self::prepareStrWithFilter($data);
        $countAll = count(DbQuery::otherOuery($sql, true));
        $sql .= " LIMIT {$count} OFFSET {$offset} ";
        $result = DbQuery::otherOuery($sql, true);
        $result['count'] = $countAll;
        return $result;

    }

    public static function prepareStrWithFilter($data)
    {
        $sql = "SELECT DISTINCT firms.id_firm, firms.firm_name, firms.description, firms.logo FROM `firms` "
                . " INNER JOIN firms_users ON (firms_users.id_firm = firms.id_firm) "
                . " WHERE firms.id_firm  IN (SELECT firms.id_firm FROM `firms` INNER JOIN "
                . " firms_users ON (firms_users.id_firm = firms.id_firm)"
                . " GROUP BY firm_name HAVING ";
        $count = 0;
        foreach ($data as $key => $item){
            if($key == 'literaDo' || $key == 'literaOt'){
                if($data['literaOt'] != '' || $data['literaDo'] != ''){
                    if($data['literaOt'] != '' && $data['literaDo'] == '' && $key == 'literaOt' && $count == 0){
                        $count++;
                        $sql .= "( firms.firm_name BETWEEN '" . $item . "%' AND " . Other::FirstOrLastLitera($item) . "% ) ";
                    }else if($data['literaOt'] == '' && $data['literaDo'] != '' && $key == 'literaDo' && $count == 0){
                        $count++;
                        $sql .= "( firms.firm_name BETWEEN '" . Other::FirstOrLastLitera($item, true) . "%' AND " . $item . "% ) ";
                    }else if($data['literaOt'] != '' && $data['literaDo'] != '' && $key == 'literaOt' && $count == 0){
                        $count++;
                        $sql .= "( firms.firm_name BETWEEN '" . $data['literaOt'] . "%' " ." AND '" . $data['literaDo'] . "%'   )";
                    }
                }
            }
            if($key == 'chisloOt' || $key == 'chisloDo'){
                if($data['chisloOt'] > $data['chisloDo'] && $key == 'chisloOt'){
                    if($count == 0){
                        $count++;
                        $sql .= "( COUNT(firms.id_firm) BETWEEN " . (int) $item ." AND "
                        . "(SELECT MAX(`count`) FROM (SELECT COUNT(firms.id_firm) AS `count` FROM `firms` INNER JOIN "
                        . " firms_users ON (firms_users.id_firm = firms.id_firm) "
                        . " GROUP BY firms.firm_name) AS `T`))) ";
                    }else if($count >= 1) {
                        $count++;
                        $sql .= " AND ( COUNT(firms.id_firm) BETWEEN " . (int)$item . " AND "
                            . "(SELECT MAX(`count`) FROM (SELECT COUNT(firms.id_firm) AS `count` FROM `firms` INNER JOIN "
                            . " firms_users ON (firms_users.id_firm = firms.id_firm) "
                            . " GROUP BY firms.firm_name) AS `T`))) ";
                    }
                }else if($data['chisloOt'] != '0' &&  $data['chisloDo'] == '0' && $key == 'chisloOt'){
                    if($count == 0){
                        $count++;
                        $sql .= "( COUNT(firms.id_firm) BETWEEN " . (int) $item ." AND "
                            . "(SELECT MAX(`count`) FROM (SELECT COUNT(firms.id_firm) AS `count` FROM `firms` INNER JOIN "
                            . " firms_users ON (firms_users.id_firm = firms.id_firm) "
                            . " GROUP BY firms.firm_name) AS `T`)) ";
                    }else if($count >= 1) {
                        $count++;
                        $sql .= " AND ( COUNT(firms.id_firm) BETWEEN " . (int)$item . " AND "
                            . "(SELECT MAX(`count`) FROM (SELECT COUNT(firms.id_firm) AS `count` FROM `firms` INNER JOIN "
                            . " firms_users ON (firms_users.id_firm = firms.id_firm) "
                            . " GROUP BY firms.firm_name) AS `T`)) ";
                    }
                }else if($data['chisloOt'] == '0' && $data['chisloDo'] != '0' && $key == 'chisloDo'){
                    if($count == 0){
                        $count++;
                        $sql .= " ( COUNT(firms.id_firm) BETWEEN (SELECT MIN(`count`) FROM (SELECT COUNT(firms.id_firm) AS `count` FROM `firms` INNER JOIN "
                            . " firms_users ON (firms_users.id_firm = firms.id_firm) "
                            . " GROUP BY firms.firm_name) AS `T`) "
                            . " AND " . (int) $item . " )) ";
                    }else if($count >= 1) {
                        $count++;
                        $sql .= " AND ( COUNT(firms.id_firm) BETWEEN (SELECT MIN(`count`) FROM (SELECT COUNT(firms.id_firm) AS `count` FROM `firms` INNER JOIN "
                            . " firms_users ON (firms_users.id_firm = firms.id_firm) "
                            . " GROUP BY firms.firm_name) AS `T`) "
                            . " AND " . (int) $item . " )) ";
                    }
                }else if(($data['chisloOt'] != '0' && $data['chisloDo'] != '0') && $key == 'chisloOt'){
                    if($count == 0){
                        $count++;
                        $sql .= " ( COUNT(firms.id_firm) BETWEEN " . (int) $data['chisloOt'] . " AND " . (int) $data['chisloDo'] . " )) ";
                    }else if($count >= 1){
                        $count++;
                        $sql .= " AND ( COUNT(firms.id_firm) BETWEEN " . (int) $data['chisloOt'] . " AND " . (int) $data['chisloDo'] . " )) ";
                    }
                }else if($data['chisloOt'] == '0' && $data['chisloDo'] == '0' && $key == 'chisloOt'){
                    $sql .= " ) ";
                }

            }

        }
        return $sql;
    }


    public static function countCompamies()
    {
        return DbQuery::getOtherData("COUNT(`id_firm`) AS `count`", "firms");
    }
}