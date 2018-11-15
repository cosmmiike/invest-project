<?php

namespace app\core;

use app\core\View;

class Router {

  protected $routes =[];
  protected $params =[];

  function __construct() {
    $array = require 'app/config/routes.php';
    foreach ($array as $key => $value) {
      $this->add($key, $value);
    }
  }

  public function add($route, $parameters) {
    $route = '#^index.php'.$route.'$#';
    $this->routes[$route] = $parameters;
  }

  public function match() {
    $url = trim($_SERVER['REQUEST_URI'], '/');
    foreach ($this->routes as $route => $parameters) {
      if (preg_match($route, $url, $matches)) {
        $this->parameters = $parameters;
        // var_dump($matches);
        return true;
      }
    }
    return false;
  }

  public function run() {
    if ($this->match()) {
      $path = 'app\controllers\\'.ucfirst($this->parameters['controller']).'Controller';
      if (class_exists($path)) {
        $action = $this->parameters['action'].'Action';
        if (method_exists($path, $action)) {
          $controller = new $path($this->parameters);
          $controller->$action();
        } else {
          View::errorCode(404);
        }
      } else {
        View::errorCode(404);
      }
    } else {
      View::errorCode(404);
    }
  }

}

?>
