<?php

namespace app\core;

use app\core\View;

abstract class Controller {

  public $route;
  public $view;
  public $access;

  public function __construct($route) {
    $this->route = $route;
    if (!$this->checkAccess()) {
      View::errorCode(403);
    }
    $this->view = new View($route);
    $this->model = $this->loadModel($route['controller']);
  }

  public function loadModel($name) {
    $path = 'app\models\\'.ucfirst($name);
    if (class_exists($path)) {
      return new $path;
    }
  }

  public function checkAccess() {
    $this->access = require 'app/access/'.$this->route['controller'].'.php';
    if ($this->hasAccess('all')) {
      return true;
    }
    elseif (isset($_SESSION['authorized']['id']) and $this->hasAccess('authorized')) {
      return true;
    }
    elseif (!isset($_SESSION['authorized']['id']) and $this->hasAccess('guest')) {
      return true;
    }
    elseif (isset($_SESSION['admin']['id']) and $this->hasAccess('admin')) {
      return true;
    }
    return false;
  }

  public function hasAccess($key) {
    return in_array($this->route['action'], $this->access[$key]);
  }

}

?>
