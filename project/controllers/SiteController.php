<?php

class SiteController
{

  public function actionIndex()
  {
    $arr  = Companies::getCompanies();
    require_once(ROOT . '/views/index.php');
    return true;
  }



}
