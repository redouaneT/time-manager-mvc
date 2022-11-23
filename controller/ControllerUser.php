<?php
RequirePage::requireModel('Model');
RequirePage::requireModel('ModelUser');

class ControllerUser
{

    public function index()
    {
        $user = new ModelUser;
        $select = $user->select();
        twig::render("template/admin/user/user-index.twig", [
            'users' => $select,
            'user_list' => "Liste de User"
        ]);
    }

    public function add()
    {
        twig::render('template/admin/user/user-add.twig');
    }

    public function store()
    {
        // print_r($_POST);
        $user = new ModelUser;
        $insert = $user->insert($_POST);
        requirePage::redirectPage('user/index');
    }

    public function show($id)
    {
        $user = new ModelUser;
        $selectUser = $user->selectId($id);
        twig::render('template/admin/user/user-show.twig', ['user' => $selectUser]);
    }

    public function edit($id)
    {
        $user = new ModelUser;
        $selectUser = $user->selectId($id);
        twig::render('template/admin/user/user-edit.twig', ['user' => $selectUser]);
    }

    public function update()
    {
        $user = new ModelUser;
        $update = $user->update($_POST);
        requirePage::redirectPage('user/index');
    }
    public function delete()
    {
        $user = new ModelUser;
        $delete = $user->delete($_POST["id"]);
        requirePage::redirectPage('user/index');
    }
}
