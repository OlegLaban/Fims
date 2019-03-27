<?php
/**
 * Created by PhpStorm.
 * User: gelo
 * Date: 26.3.19
 * Time: 15.37
 */

class Companies
{
    public static function getCompanies()
    {
        $sql = "SELECT * FROM `firms` LIMIT " . Config::COUNT_NOTES_ON_PAGE;
        return DbQuery::otherOuery($sql, true);
    }

    public static function getCompniesWithPage($page)
    {
        return  DbQuery::getAllDataWithPage('firms', $page);
    }

    public static function countCompamies()
    {
        return DbQuery::getOtherData("COUNT(`id_firm`) AS `count`", "firms");
    }
}