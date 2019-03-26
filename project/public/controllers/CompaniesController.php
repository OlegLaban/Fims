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
        $arr = Companies::getCompniesWithPage($page);
        $count = Companies::countCompamies();
        $pagination = new Pagination($count['count'], $page, Config::COUNT_NOTES_ON_PAGE, 'p-');
        require_once ROOT  . '/views/companies/index.php';
        return true;
    }
}