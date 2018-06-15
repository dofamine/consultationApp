<?php
defined("DOCROOT") or die ("NO DIRECT ACCESS");
include CLASS_PATH . "Config.php";
include CLASS_PATH . "Router.php";
include CLASS_PATH . "View.php";
include CLASS_PATH . "Model.php";
include CLASS_PATH . "Entity.php";
include CLASS_PATH . "Cache.php";
include CLASS_PATH . "AutoLoader.php";
session_start();
spl_autoload_register("Autoloader::load");
$router = Router::getInstance();

$router->addRoute(new Route("",
    [
        "controller" => "main",
        "action" => "index"
    ]));
$router->addRoute(new Route("register",
    [
        "controller" => "main",
        "action" => "register"
    ]));
$router->addRoute(new Route("regaction",
    [
        "controller" => "auth",
        "action" => "register"
    ]));
$router->addRoute(new Route("logout",
    [
        "controller" => "auth",
        "action" => "logout"
    ]));
$router->addRoute(new Route("deeplogout",
    [
        "controller" => "auth",
        "action" => "logoutAll"
    ]));
$router->addRoute(new Route("login",
    [
        "controller" => "auth",
        "action" => "login"
    ]));
$router->addRoute(new Route("post/showall/{?id}",
    [
        "controller" => "post",
        "action" => "myPosts"
    ]));
$router->addRoute(new Route("/post/new",
    [
        "controller" => "post",
        "action" => "new"
    ]));
$router->addRoute(new Route("/post/add",
    [
        "controller" => "post",
        "action" => "add"
    ]));
$router->addRoute(new Route("/post/details/{id}",
    [
        "controller" => "post",
        "action" => "details"
    ]));
$router->addRoute(new Route("/post/like/{id}",
    [
        "controller" => "post",
        "action" => "like"
    ]));
$router->addRoute(new Route("/categories/{id}/{?page}",
    [
        "controller" => "menu",
        "action" => "showCategory"
    ]));
$router->addRoute(new Route("profile",
    [
        "controller" => "profile",
        "action" => "show"
    ]));
$router->addRoute(new Route("profile/addinfo",
    [
        "controller" => "profile",
        "action" => "addinfo"
    ]));
$router->addRoute(new Route("api/cities/{id}",
    [
        "controller" => "api",
        "action" => "getCities"
    ]));
$router->addRoute(new Route("api/cache",
    [
        "controller" => "api",
        "action" => "getCache"
    ]));
$router->addRoute(new Route("admin/{?action}/{?id}",
    [
        "controller" => "admin",
        "action" => "index"
    ]));
try {
    $router->run();
} catch (RouterException $exception) {
    echo $exception->getMessage();
//    $router->redirect404();
};
