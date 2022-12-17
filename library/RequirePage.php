<?php

class RequirePage
{
    static public function requireModel($model)
    {
        return require_once "model/$model.php";
    }
    static public function redirectpage($page)
    {
        return header("Location: http://localhost/timeManagerMvc/$page");
    }
    static public function requireLibrary($library)
    {
        return require_once "library/$library.php";
    }
}
