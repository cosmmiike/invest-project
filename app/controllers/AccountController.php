<?php

namespace app\controllers;

use app\core\Controller;

class AccountController extends Controller {

  public function loginAction() {
    if (!empty($_POST)) {
      $this->view->location('/index.php/account/register');
    }
    $this->view->render('Login page');
  }

  public function registerAction() {

    $this->view->render('Register page');
  }

}

?>
