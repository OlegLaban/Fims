<?php
return array(

  'users/view/([0-9]+)' => 'users/view/$1',
  'users/p-([0-9]+)' => 'users/index/$1',
  'users' => 'users/index',


  'companies/view/([0-9]+)' => 'companies/viewCompany',
  'companies/p-([0-9]+)' => 'companies/index/$1',
  'companies' => 'companies/index',

  'admin/addcompany' => 'admin/addCompany',
  'admin/addworker' => 'admin/addWorker',
  'admin/p-([0-9]+)' => 'admin/index/$1',
  'admin/delCompany/([0-9]+)' => 'admin/delCompany/$1',
  'admin/delUser/([0-9]+)' => 'admin/delUser/$1',
  'admin/edituser/([0-9]+)' => 'admin/editUser/$1',
  'admin/user/p-([0-9]+)' => 'admin/usersPage/$1',
  'admin/user' => 'admin/usersPage',
  'admin' => 'admin/index',

  'site/AddImgC' => 'site/AddImg',
  'site/AddImgW' => 'site/AddImgW',
  '' => 'site/index'

);
