<?php
RequirePage::requireModel('Model');
RequirePage::requireModel('ModelLog');

class ControllerLog
{
    protected  $userInfo;
    public function __construct()
    {
        // Construire les information du log à chaque initialisation de la classe
        $this->userInfo = array(
            'visitor_username' =>  (isset($_SESSION['username'])) ? $_SESSION['username'] : "Visiteur",
            'visitor_ip' => $_SERVER['REMOTE_ADDR'],
            'visited_url' => (isset($_SERVER['PATH_INFO'])) ? $_SERVER['PATH_INFO'] : "/" 
        );

        // Appeler la fonction store pour stocker le journal dans la base de donnée
        if (!isset($_GET['id'])) {
            $this->store();
        }

    }
    public function index()
    {
     
        if (isset($_SESSION["privilege_id"]) && $_SESSION["privilege_id"] === '1'){
            $log = new ModelLog;
            $select = $log->select('visited_at');
            twig::render("template/admin/log/log-index.twig", [
                'logs' =>  $select
            ]);
        }else {
            requirePage::redirectPage('home/welcome');
        }
    
    }

    protected function store()
    {
        $log = new ModelLog;
        $insert =  $log->insert($this->userInfo);
    }

    public function delete()
    {
        // Si l'utilisateur n'est pas un admin, on le renvoi vers la page d'accueil après avoir enregistré les information de log 
        if (isset($_SESSION["privilege_id"]) && $_SESSION["privilege_id"] === '1'){
            $log = new ModelLog;
            $delete =  $log->delete($_POST["id"]);
            requirePage::redirectPage('log/index');
        }else {
            requirePage::redirectPage('home/welcome');
        }
    }
}
