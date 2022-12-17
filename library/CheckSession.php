<?php

class CheckSession {

 static public function sessionAuth(){
    
    if(isset($_SESSION['fingerPrint']) and $_SESSION['fingerPrint'] === md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR'])){
         return true;
        }else{
            requirePage::redirectPage('user/login');
        }
    }
}

?>