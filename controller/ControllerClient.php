<?php
RequirePage::requireModel('Model');
RequirePage::requireModel('ModelClient');

class ControllerClient
{
    public function __construct()
    {
        
        $_POST["user_id"] = 1;
    }
    public function index()
    {
        $client = new ModelClient;
        $select =  $client->select();
        twig::render("template/client/client-index.twig", [
            'clients' => $select,
            'client_list' => "Liste de Client"
        ]);
    }

    public function add()
    {
        twig::render('template/client/client-add.twig');
    }

    public function store()
    {
        // print_r($_POST);
        $client = new ModelClient;
        $insert =  $client->insert($_POST);
        requirePage::redirectPage('client/index');
    }

    public function show($id)
    {
        $client = new ModelClient;
        $selectClient =  $client->selectId($id);
        twig::render('template/client/client-show.twig', ['client' => $selectClient]);
    }

    public function edit($id)
    {
        $client = new ModelClient;
        $selectClient =  $client->selectId($id);
        twig::render('template/client/client-edit.twig', ['client' => $selectClient]);
    }

    public function update()
    {
        $client = new ModelClient;
        $update =  $client->update($_POST);
        requirePage::redirectPage('client/index');
    }
    public function delete()
    {
        $client = new ModelClient;
        $delete =  $client->delete($_POST["id"]);
        requirePage::redirectPage('client/index');
    }
}
