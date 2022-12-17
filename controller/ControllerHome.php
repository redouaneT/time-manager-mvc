<?php

class ControllerHome
{
    protected  $userAccess = "";
    public function __construct()
    {
        if (isset($_SESSION["privilege_id"]) && isset($_POST)){
     
            if ($_SESSION["privilege_id"] === "1") {
                $this->userAccess = "admin"; // admin
            }else{
                $this->userAccess = "user";; //user
            }
        }else {
       
            $this->userAccess = "guest"; // Guest
            $_POST["privilege_id"] = 2;
        }
     
    }
    public function welcome()
    {
        if ($this->userAccess === "guest" || $this->userAccess === "" ) {
            twig::render("template/welcome.twig");
        }else {
            requirePage::redirectPage('home/index');
        }
    }
    public function index()
    {
        twig::render("template/index.twig");
    }

    public function error()
    {
        twig::render('home-error.php');
    }
}
