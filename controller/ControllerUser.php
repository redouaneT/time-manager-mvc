<?php
RequirePage::requireModel('Model');
RequirePage::requireModel('ModelUser');
RequirePage::requireModel('ModelCountry');
RequirePage::requireModel('ModelCity');
RequirePage::requireModel('ModelPrivilege');
RequirePage::requireLibrary('Validation');

class ControllerUser
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
    public function index()
    {
       if ($this->userAccess === "admin") {
            $user = new ModelUser;
            $select = $user->select();
            twig::render("template/admin/user/user-index.twig", [
                'users' => $select,
                'user_list' => "Liste de User"
            ]);
       }else if ($this->userAccess === "user") {
            requirePage::redirectPage('home/index');
       }else {
            requirePage::redirectPage('home/welcome');
       }
    }

    public function add($request = null, $errors = null)
    {
       if ($this->userAccess === "admin" || $this->userAccess === "guest") {
        $country = new ModelCountry;
        $selectCountry =  $country->select('name');

        $privilege = new ModelPrivilege;
        $selectPrivilege =  $privilege->select('name');

        $data = [
            'countries' => $selectCountry,
            'title' => "Pays",
            'privileges' => $selectPrivilege
        ];

        if (isset($request)) {
            $data['user'] = $request;
            if (isset($errors)) {
                $data['errors'] = $errors;
            }
        }
        if ($this->userAccess === "admin") {
            twig::render("template/admin/user/user-add.twig", $data);
        }else {
            twig::render("template/auth/signup.twig", $data);
        }  
       }else {
            requirePage::redirectPage('home/index');
       }
    }

    public function store()
    {
        if ($this->userAccess = "admin" || $this->userAccess = "guest") {
            $validation = new Validation;
            extract($_POST);
            $validation->name('Username')->value($username)->required()->max(50);
            $validation->name('Nom')->value($first_name)->pattern('alpha')->required()->max(55);
            $validation->name('Prénom')->value($last_name)->pattern('alpha')->required()->max(55);
            $validation->name('Courriel')->value($email)->pattern('email')->required()->max(50);
            $validation->name('Mot de passe')->value($password)->max(20)->min(6);
            $validation->name('Date de naissance')->value($birthday)->pattern('date_ymd')->required();

            if($validation->isSuccess()){

                $user = new ModelUser;

                $options = [
                    'cost' => 10,
                ];
               
                $_POST['password']= password_hash($_POST['password'], PASSWORD_BCRYPT, $options);
                $userInsert = $user->insert($_POST);

                requirePage::redirectPage('user/login');

            }else{

                $errors = $validation->displayErrors();

                $country = new ModelCountry;
                $selectCountry =  $country->select('name');

                $privilege = new ModelPrivilege;
                $selectPrivilege = $privilege->select();

                twig::render('template/auth/signup.twig', ['errors' => $errors, 'countries' => $selectCountry, 'privileges' => $selectPrivilege, 'user' => $_POST]);
            }
        }else {
            requirePage::redirectPage('home/index');
       }
    }

    public function show($id)
    {
        if ($this->userAccess === "admin"){
            $user = new ModelUser;
            $selectUser = $user->selectId($id);
            twig::render('template/admin/user/user-show.twig', ['user' => $selectUser]);
        }else{
            requirePage::redirectPage('home/error');
        }
    }

    public function edit($id, $id2)
    {
        if ($this->userAccess === "admin"){
            $user = new ModelUser;
            $selectUser = $user->selectId($id);
    
            $country = new ModelCountry;
            $selectCountries =  $country->select('name');
    
            $city = new ModelCity;
            $selectCity =  $city->selectByForeignKey($id2);
    
            $privilege = new ModelPrivilege;
            $selectPrivilege =  $privilege->select();
    
            twig::render('template/admin/user/user-edit.twig', ['user' => $selectUser, 'countries' => $selectCountries, 'cities' => $selectCity, 'privileges' => $selectPrivilege]);
        }else{
            requirePage::redirectPage('home/error');
        }
      
    }

    public function update()
    {
        if ($this->userAccess === "admin"){
            $user = new ModelUser;
            $update = $user->update($_POST);
            requirePage::redirectPage('user/index');
        
        }else{
            requirePage::redirectPage('home/error');
        }

    }
    public function delete()
    {
        if ($this->userAccess === "admin"){
            $user = new ModelUser;
            $delete = $user->delete($_POST["id"]);
            requirePage::redirectPage('user/index');
        
        }else{
            requirePage::redirectPage('home/error');
        }
    }

    public function login(){
        if ($this->userAccess === "guest") {
            twig::render('template/auth/login.twig');
        }else {
            requirePage::redirectPage('home/index');
        }
    }

    public function auth(){
        $validation = new Validation;
        extract($_POST);
        $validation->name('username')->value($username)->pattern('alpha')->required()->max(50);
        $validation->name('password')->value($password)->required();

        if($validation->isSuccess()){
            $user = new ModelUser;
            $checkUser = $user->checkUser($_POST);
            twig::render('template/auth/login.twig', ['errors' => $checkUser, 'user' => $_POST]);
        }else{
            $errors = $validation->displayErrors();
            twig::render('template/auth/login.twig', ['errors' => $errors, 'user' => $_POST]);
        }
    }
    public function logout(){
        session_destroy();
        requirePage::redirectPage('user/login');
    }
}
