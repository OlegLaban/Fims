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
        if(isset($_SESSION['dataFilterFirms'])){
            unset($_SESSION['dataFilterFirms']);
        }
        if(isset($_POST['unsetSub'])){
            unset($_SESSION['dataFilterUser']);
        }
        if(isset($_POST['subFilter']) || isset($_SESSION['dataFilterUser'])){
            if(isset($_POST['subFilter'])){
                $data = $_POST['filter'];
                $_SESSION['dataFilterUser'] = $data;
            }else{
                $data = $_SESSION['dataFilterUser'];
            }
            $arr = Users::getFilterUsersAndFirmsWithPage($page, $data);
            $count = $arr['count'];
            unset($arr['count']);
        }else{
            $arr = Users::getAllUsersAndFirmsWithPage($page);
            $count = Users::countUsers()['count'];
       }
        if(isset($_SESSION['dataFilterUser'])){
            $data = $_SESSION['dataFilterUser'];
        }
        $arrCompanyName = Companies::getFirmsName();
        $pagination = new Pagination($count, $page, Config::COUNT_NOTES_ON_PAGE, 'p-');
        $lastUsersArr = Users::getLastAddUsers(Config::LAST_ADD_USERS);
        require_once ROOT . '/views/user/index.php';
        return true;
    }
}