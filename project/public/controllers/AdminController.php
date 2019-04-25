<?php


class AdminController
{

    public function actionIndex($page = 1)
    {
        $data = [];
        if (isset($_SESSION['unsetSub'])) {
            unset($_SESSION['unsetSub']);
        }
        if (isset($_POST['resetFilterFirm'])) {
            unset($_SESSION['dataFilterFirm']);
        }
        if (isset($_POST['subFilterFirm']) || isset($_SESSION['dataFilterFirm'])) {
            if (isset($_POST['filterFirm'])) {
                $data = $_POST['filterFirm'];
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
        require_once ROOT . '/views/admin/index.php';
        return true;
    }

    public function actionUsersPage($page = 1)
    {
        $data = [];
        if (isset($_SESSION['dataFilterFirms'])) {
            unset($_SESSION['dataFilterFirms']);
        }
        if (isset($_POST['unsetSub'])) {
            unset($_SESSION['dataFilterUser']);
        }
        if (isset($_POST['subFilter']) || isset($_SESSION['dataFilterUser'])) {
            if (isset($_POST['subFilter'])) {
                $data = $_POST['filter'];
                $_SESSION['dataFilterUser'] = $data;
            } else {
                $data = $_SESSION['dataFilterUser'];
            }
            $arr = Users::getFilterUserWithPage($page, $data);
            $count = $arr['count'];
            unset($arr['count']);
        } else {
            $arr = Users::getAllUsersAndFirmsWithPage($page);
            $count = Users::countUsers()[0]['count'];
        }
        if (isset($_SESSION['dataFilterUser'])) {
            $data = $_SESSION['dataFilterUser'];
        }
        $arrCompanyName = Companies::getFirmsName();
        $pagination = new Pagination($count, $page, Config::COUNT_NOTES_ON_PAGE, 'p-');
        $lastUsersArr = Users::getLastAddUsers(Config::LAST_ADD_USERS);
        require_once ROOT . '/views/admin/userPage.php';
        return true;
    }

    public function actionAddCompany()
    {
        if (isset($_POST['subAddCompany'])) {
            $data = $_POST;
            unset($data['subAddCompany']);
            Admin::addNewCompany($data);
        }
        $src = Config::SRC_IMG_COMPANIES;
        $lastUsersArr = Users::getLastAddUsers(Config::LAST_ADD_USERS);
        require_once ROOT . '/views/admin/addCompany.php';
        return true;
    }

    public function actionAddWorker()
    {
        if (isset($_POST['subAddWorker'])) {
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

    public function actionDelCompany($id = false)
    {
        $arr = [
            'id_firm' => (int) $id,
            'firms_users',
            'firms'
        ];
        Admin::Delete($id, $arr);
        header("Location: " . $_SERVER['HTTP_REFERER']);
    }

    public function actionEditUser($id)
    {
        $arrDataWoker = Users::getUserById($id);
        $arrDataWoker = reset($arrDataWoker);
        $src = Config::SRC_IMG_WORKERS;
        $companies = Companies::getFirmsName();
        $lastUsersArr = Users::getLastAddUsers(Config::LAST_ADD_USERS);
        require_once ROOT . '/views/admin/editUser.php';
        return true;
    }

    public function actionDelUser($id = false)
    {
        $arr = [
            'id_user' => (int) $id,
            'firms_users',
            'users'

        ];
        Admin::Delete($id, $arr);
        header("Location: " . $_SERVER['HTTP_REFERER']);
        return true;
    }

    public function actionAddFromXMLFile()
    {
        if(isset($_POST['subAddXml'])){
            $file = Admin::UploadFile('data.xml');
            $arrValuesWorker = [
                'last_name',
                'first_name',
                'father_name',
                'birthd_day',
                'inn',
                'cnils',
                'data_start_job'

            ];
            $arrValuesCompany = [
                'firm_name',
                'ogrn',
                'oktmo'
            ];
            Admin::parserXmlFile($file,  $arrValuesWorker, $arrValuesCompany);

        }
        $lastUsersArr = Users::getLastAddUsers(Config::LAST_ADD_USERS);
        require_once ROOT . '/views/admin/addFromXML.php';
        return true;
    }


}