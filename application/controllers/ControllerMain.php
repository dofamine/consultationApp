<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 21.03.2018
 * Time: 13:24
 */

class ControllerMain extends Controller
{
    private $menuCtrl;
    private $rightSide;

    public function __construct()
    {
        $this->menuCtrl = new ControllerMenu();
        $this->menuCtrl->rightMenu();
        $this->rightSide = new ControllerHeaderRightSide();
    }
    private function rightSide(){
         if (!ModuleAuth::instance()->isAuth()){
            $this->rightSide->logformInit();
        } else {
            $this->rightSide->userbarInit();
        }
    }

    public function action_index()
    {
        $view = new View("posts/posts");
        $view->useTemplate();
        $this->rightSide();
        $view->rightSide = $this->rightSide->getResponse();
        $view->posts = ModelPost::instance()->getTop(5);
        $view->rightmenu = $this->menuCtrl->getResponse();
        $this->response($view);
    }

    public function action_register()
    {
        if (ModuleAuth::instance()->isAuth()) $this->redirect("Location: ".$_SERVER["HTTP_REFERER"]);
        $view = new View("register");
        $view->useTemplate();
        $this->rightSide->logformInit();
        $view->rightSide = $this->rightSide->getResponse();
        $view->rightmenu = $this->menuCtrl->getResponse();
        if(!empty($_SESSION["validate_error"])){
            $view->error = $_SESSION["validate_error"];
            $view->old = $_SESSION["old"];
        }
        if (!empty($_SESSION["data_error"])){
            $view->data_error = $_SESSION["data_error"];
            $view->old = $_SESSION["old"];
        }
        unset($_SESSION["validate_error"]);
        unset($_SESSION["old"]);
        unset($_SESSION["data_error"]);
        $this->response($view);
    }
}