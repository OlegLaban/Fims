<?php
return array(

  'users/p-([0-9]+)' => 'users/index/$1',
  'users' => 'users/index',

  'companies/p-([0-9]+)' => 'companies/index/$1',
  'companies' => 'companies/index',

  'admin/addcompany' => 'admin/addCompany',
  'admin/addworker' => 'admin/addWorker',
  'admin/p-([0-9]+)' => 'admin/index/$1',
  'admin/delCompany/([0-9]+)' => 'admin/delCompany/$1',
  'admin/user/p-([0-9]+)' => 'admin/usersPage/$1',
  'admin/user' => 'admin/usersPage',
  'admin' => 'admin/index',

  'site/AddImgC' => 'site/AddImgC',
  'site/AddImgW' => 'site/AddImgW',
  '' => 'site/index'

);
