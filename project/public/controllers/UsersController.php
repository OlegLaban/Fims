<?php
/**
 * Created by PhpStorm.
 * User: gelo
 * Date: 26.3.19
 * Time: 15.25
 */

class UsersController
{
    public function actionIndex($page = 1)
    {
        $arr = Users::getAllUsersWithPage($page);
        $count = Users::countUsers();
        $pagination = new Pagination($count['count'], $page, Config::COUNT_NOTES_ON_PAGE, 'p-');
        require_once ROOT . '/views/user/index.php';
        return true;
    }
}