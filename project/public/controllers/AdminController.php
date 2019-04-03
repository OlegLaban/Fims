<?php


class AdminController
{

    public function actionIndex()
    {
        require_once ROOT . '/views/admin/index.php';
        return true;
    }

    public function actionAddCompany()
    {
        if(isset($_POST['subAddCompany'])){
            $data = $_POST;
            unset($data['subAddCompany']);
            Admin::addNewCompany($data);
        }
        $src = Config::SRC_IMG_COMPANIES;
        $lastUsersArr = Users::getLastAddUsers(Config::LAST_ADD_USERS);
        require_once ROOT  . '/views/admin/addCompany.php';
        return true;
    }

    public function actionAddWorker()
    {
        if(isset($_POST['subAddWorker'])){
           $data = $_POST;
           unset($data['subAddWoker']);
           Admin::addNewWorker($data);
        }
        $companies = Companies::getFirmsName();
        $src = Config::SRC_IMG_WORKERS;
        $lastUsersArr = Users::getLastAddUsers(Config::LAST_ADD_USERS);
        require_once ROOT . '/views/admin/addWorker.php';
        return true;
    }



}