<?php

class Users
{
    public static function getAllUsersWithPage($page, $count = Config::COUNT_NOTES_ON_PAGE)
    {
        $count = intval($count);
        $page = intval($page);
        $offset = ($page - 1) * $count;
        $sql = "SELECT firms_users.id_firm, firms_users.id_user, firms.firm_name, "
                ." users.first_name, users.Last_name, birthd_day FROM `firms_users` INNER JOIN `firms` "
                . " ON (firms.id_firm = firms_users.id_firm) INNER JOIN `users` ON (users.id_user = firms_users.id_user)"
                ." LIMIT {$count} OFFSET {$offset} ";
        return DbQuery::otherOuery($sql, true);
    }

    public static function countUsers()
    {
        return DbQuery::getOtherData("COUNT(`id_firm`) AS `count`", "firms_users");
    }
}