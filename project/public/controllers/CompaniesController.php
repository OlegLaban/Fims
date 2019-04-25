<?php
/**
 * Created by PhpStorm.
 * User: gelo
 * Date: 26.3.19
 * Time: 12.25
 */

class CompaniesController
{
    public function actionIndex($page = 1)
    {
        $page = $page == 0 ? 1 : $page;
        $data = [];
        if (isset($_SESSION['unsetSub'])) {
            unset($_SESSION['unsetSub']);
        }
        if (isset($_GET['resetFilterFirm'])) {
            unset($_SESSION['dataFilterFirm']);
        }
        if (isset($_GET['subFilterFirm']) || isset($_SESSION['dataFilterFirm'])) {
            if (isset($_GET['filterFirm'])) {
                $data = $_GET['filterFirm'];
                $_SESSION['dataFilterFirm'] = $data;
            } else {
                $data = $_SESSION['dataFilterFirm'];
            }

            $arr = Companies::getCompaniesFilterWithPage($page, $data);
            $count = $arr['count'];
            unset($arr['count']);
        } else {
            $arr = Companies::getCompniesWithPage($page);
            $count = Companies::countCompamies()[0]['count'];
        }

        $filterCompany = Companies::getParamsFilter($data);


        $pagination = new Pagination($count, $page, Config::COUNT_NOTES_ON_PAGE, 'p-');
        $lastUsersArr = Users::getLastAddUsers(Config::LAST_ADD_USERS);
        require_once ROOT . '/views/companies/index.php';
        return true;
    }

    public function actionViewCompany()
    {
        $lastUsersArr = Users::getLastAddUsers(Config::LAST_ADD_USERS);
        require_once ROOT . '/views/companies/viewCompany.php';
        return true;
    }
}