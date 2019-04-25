<?php
class Router
{

  private $routes;

  public function __construct()
  {
    $routesPath = ROOT . '/config/Routes.php';
    $this->routes = include($routesPath);
  }

  private function getURI()
  {
    if(!empty($_SERVER['REQUEST_URI'])){
       return trim($_SERVER['REQUEST_URI'], '/');

    }
  }

  public function run()
  {
    //Получить строку запроса
      $uri = $this->getURI();

    //Проверить наличие такого запроса
      foreach ($this->routes as $uriPattern => $path) {

          //admin
          //admin/user

          //Сравниваем $uriPattern и uri
          if(preg_match("~$uriPattern~", $uri)){
            $internalRoute = preg_replace("~$uriPattern~", $path, $uri);
            //Определяем контроллер

            $segments = explode('/', $internalRoute);
            $controllerName = array_shift($segments).'Controller';
            $controllerName = ucfirst($controllerName);
            $actionName = 'action'.ucfirst(array_shift($segments));
            $controllerFile = ROOT . '/controllers/' . $controllerName . '.php';
            $parameters =  $segments;

            if(file_exists($controllerFile)){
              include_once($controllerFile);
            }
            $controllerObject  = new $controllerName;
            $result = NULL;
            $result = call_user_func_array(array($controllerObject, $actionName), $parameters);
            if($result != NULL){
              break;
            }

          }

      }

  }

}
