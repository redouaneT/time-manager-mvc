<?php

class Twig
{
    static public function render($template, $data = array())
    {
        $loader = new \Twig\Loader\FilesystemLoader('view');
        // $twig = new \Twig\Environment($loader, array('auto_reload' => true,'cache' => false));
        $twig = new \Twig\Environment($loader, array('auto_reload' => true, 'debug' => true));
        $twig->addExtension(new \Twig\Extension\DebugExtension());

        $twig->addGlobal('path', 'http://localhost/timeManagerMvc/');

        // Si une session est ouverte, on ajoute une variable global contenant la session
        if (isset($_SESSION["username"])) {
            $twig->addGlobal('session', $_SESSION);
        }
        
        echo $twig->render($template, $data);
    }
}
