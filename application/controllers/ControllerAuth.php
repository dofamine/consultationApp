<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 11.04.2018
 * Time: 13:30
 */

class ControllerAuth extends Controller
{
    /**
     * ythhsh
     * @var ModuleValidator\Builder $a;
     */
    private $a;
    private static function is_empty()
    {
        foreach (func_get_args() as $arg) {
            if (empty($arg)) return true;
        }
        return false;
    }
    private function oldValues(array $arr){
        $_SESSION["old"] = $arr;

    }
    public function action_register()
    {
//        $this->a->

        ModuleValidator::trimArray($_POST);//perenesti v class array rabotu s massivami
        $photo = @$_FILES["photo"];
        extract($_POST);//ploho ijection alert error, risk ijecii pryamoi !!!!
        $validator = new ModuleValidator($_POST);
        $validator->addRule("login","validate error login",ModuleValidate::getBuilder()->containsLower()->len(4,6));
        $validator->addRule("pass","validate error pass",ModuleValidate::getBuilder()->password()->withoutSpaces());
        $validator->addRule("conf","validate error conf",ModuleValidate::getBuilder()->password()->withoutSpaces());
        $_SESSION["data_error"] = [];
        try {
            if (ModuleValidator::isSomeEmpty($_POST)) throw new Exception("Enter all fields");
            if ($conf !== $pass) throw new Exception("Passwords are not similar");
            if (!$validator->execValidation($_SESSION["data_error"])){
                $this->oldValues([
                    "login" => $login,
                    "mail" => $mail,
                    "phone" => $phone
                ]);
                $this->redirect($_SERVER["HTTP_REFERER"]);
                return;
            }
            try {
                $user_id = ModuleAuth::instance()->register($login, $pass,
                    ["email" => $mail, "phone" => $phone]);
                if ( $photo["size"] > 0 ) {
                    ModelImages::instance()->addAvatar($user_id,$photo);
                }
                $this->redirect(URLROOT);
            } catch (Exception $e) {
                throw new Exception($e->getMessage());
            }
        } catch (Exception $e) {
            $_SESSION["validate_error"] = $e->getMessage();
            $this->oldValues([
                "login" => $login,
                "mail" => $mail,
                "phone" => $phone
            ]);
            $this->redirect(URLROOT . "register");
        }
    }

    public function action_login()
    {
        $login = trim(@$_POST["login"]);
        $pass = trim(@$_POST["pass"]);
        $remember = isset($_POST["remember"]);
        try {
            if (self::is_empty($login, $pass)) throw new Exception("Enter all fields to log in");
            ModuleAuth::instance()->login($login, $pass, $remember);
        } catch (Exception $e) {
            $_SESSION["login_error"] = $e->getMessage();
            $_SESSION["login"] = @$_POST["login"];
        }
        $this->redirect(URLROOT);
    }

    public function action_logout()
    {
        if (!ModuleAuth::instance()->isAuth()) $this->redirect(URLROOT);
        ModuleAuth::instance()->logout();
        $_SESSION["views"] = [];
        $this->redirect(URLROOT);
    }

    public function action_logoutAll()
    {
        if (!ModuleAuth::instance()->isAuth()) $this->redirect(URLROOT);
        ModuleAuth::instance()->logout(true);
        $_SESSION["views"] = [];
        $this->redirect(URLROOT);
    }
}