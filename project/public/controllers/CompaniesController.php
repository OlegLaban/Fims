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
        if(isset($_SESSION['unsetSub'])){
            unset($_SESSION['unsetSub']);
        }
        if(isset($_POST['resetFilterFirm'])){
            unset($_SESSION['dataFilterFirm']);
        }
        if(isset($_POST['subFilterFirm']) || isset($_SESSION['dataFilterFirm'])){
            if(isset($_POST['filterFirm'])){
                $data = $_POST['filterFirm'];
                $_SESSION['dataFilterFirm'] = $data;
            }else{
                $data = $_SESSION['dataFilterFirm'];
            }

            $arr  = Companies::getCompaniesFilterWithPage($page, $data);
            $count = $arr['count'];
            unset($arr['count']);
        }else{
            $arr = Companies::getCompniesWithPage($page);
            $count = Companies::countCompamies()['count'];
        }

        $literaOt = isset($data['literaOt']) ?  $data['literaOt'] : "";
        $literaDo = isset($data['literaDo']) ?  $data['literaDo'] : "";
        $chisloOt =  isset($data['chisloOt'])  ?  $data['chisloOt'] : 0;
        $chisloDo =  isset($data['chisloDo'])  ?  $data['chisloDo'] : 0;
        $pagination = new Pagination($count, $page, Config::COUNT_NOTES_ON_PAGE, 'p-');
        $lastUsersArr = Users::getLastAddUsers(Config::LAST_ADD_USERS);
        require_once ROOT  . '/views/companies/index.php';
        return true;
    }
}