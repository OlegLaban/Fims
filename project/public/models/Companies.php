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

    public static function countCompamies()
    {
        return DbQuery::getOtherData("COUNT(`id_firm`) AS `count`", "firms");
    }
}