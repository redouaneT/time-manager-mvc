<?php
RequirePage::requireModel('Model');
RequirePage::requireModel('ModelClient');
RequirePage::requireModel('ModelCountry');
RequirePage::requireModel('ModelCity');
RequirePage::requireLibrary('Validation');

class ControllerClient
{
    public function __construct()
    {
        CheckSession::sessionAuth();
        if (isset($_SESSION['user_id'])) {
            $_POST['user_id'] = $_SESSION['user_id'];
        }
    }

    public function index()
    {
        $client = new ModelClient;
        $select =  $client->selectByColumnValue('user_id', $_SESSION['user_id']);
        twig::render("template/client/client-index.twig", [
            'clients' => $select,
            'client_list' => "Liste de Client"
        ]);
    }

    public function add()
   
    {
        $country = new ModelCountry;
        $select =  $country->select('name');
        twig::render("template/client/client-add.twig", [
            'countries' => $select,
            'title' => "Pays"
        ]);
    }

    public function store()
    {
        $validation = new Validation;

        extract($_POST);
        $validation->name('nom')->value($first_name)->pattern('alpha')->required()->max(55);
        $validation->name('prénom')->value($last_name)->pattern('alpha')->required()->max(55);
        $validation->name('courriel')->value($email)->pattern('alpha')->max(255);
        $validation->name('telephone')->value($phone)->pattern('tel')->max(25);
        $validation->name('Adresse')->value($address)->max(100);

        if($validation->isSuccess()){
            $client = new ModelClient;
            $insert =  $client->insert($_POST);
            requirePage::redirectPage('client/index');
        }else{
            $errors = $validation->displayErrors();
            twig::render('template/client/client-add.twig', ['errors' => $errors, 'client' => $_POST]);
        }
    }

    public function show($id)
    {
        $client = new ModelClient;
        $selectClient =  $client->selectId($id);
        twig::render('template/client/client-show.twig', ['client' => $selectClient]);
    }

    public function contact($id)
    {

        $client = new ModelClient;
        $selectClient =  $client->selectId($id);
        twig::render('template/client/client-contact.twig', ['client' => $selectClient]);
    }

    public function edit($id, $id2)
    {
        $client = new ModelClient;
        $selectClient =  $client->selectId($id);

        $country = new ModelCountry;
        $selectCountries =  $country->select('name');

        $city = new ModelCity;
        $selectCity =  $city->selectByForeignKey($id2);

        twig::render('template/client/client-edit.twig', ['client' => $selectClient, 'countries' => $selectCountries, 'cities' => $selectCity]);
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
