<?php

class SiteController
{

  public function actionIndex()
  {

    $arr  = Companies::getCompanies(false);
    $lastUsersArr = Users::getLastAddUsers(Config::LAST_ADD_USERS);
    require_once(ROOT . '/views/index.php');
    return true;
  }



}
