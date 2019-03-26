<?php
  spl_autoload_register(function($class){
    if(file_exists(ROOT . '/models/' . $class . '.php')){
      include_once(ROOT . '/models/' . $class . '.php');
    }
    if(file_exists(ROOT . '/components/' . $class . '.php')){
      include_once(ROOT . '/components/' . $class . '.php');
    }
  });


?>
