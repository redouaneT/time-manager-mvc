<?php

class ControllerHome
{

    public function index()
    {

        $data = [
            'name' => 'Peter',
            'welcome' => 'Welcome'
        ];
        twig::render("template/index.twig", $data);
    }

    public function error()
    {
        twig::render('home-error.php');
    }
}
