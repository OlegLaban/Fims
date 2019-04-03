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

  public function actionAddImg()
  {
      $data = $_FILES;
      $name = basename($data[0]["name"]);
      $src = ROOT  . "/img/logoCompanies/$name";
      echo "/img/logoCompanies/$name";
      move_uploaded_file($data[0]['tmp_name'], $src);
      return true;
  }

    public function actionAddImgW()
    {
        $data = $_FILES;
        $name = basename($data[0]["name"]);
        $src = ROOT  . "/img/logoWorker/$name";
        echo "/img/logoCompanies/$name";
        move_uploaded_file($data[0]['tmp_name'], $src);
        return true;
    }


}
