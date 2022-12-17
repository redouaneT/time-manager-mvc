<?php
RequirePage::requireModel('Model');
RequirePage::requireModel('ModelActivity');
RequirePage::requireLibrary('Validation');


class ControllerActivity
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

        $activity = new ModelActivity;
        $select = $activity->selectByColumnValue('user_id', $_SESSION['user_id']);
        twig::render('template/activity/activity-index.twig', [
            'activities' => $select,
            'activity_list' => "Liste des Activities"
        ]);
    }

    public function add()
    {

        twig::render('template/activity/activity-add.twig');
    }

    public function store()
    {
       

        $validation = new Validation;
        extract($_POST);
        $validation->name('type activité')->value($type)->required()->max(100);
        $validation->name('début activité')->value($starts_at)->pattern('date_ymd')->required();

        if($validation->isSuccess()){
            $activity = new ModelActivity;
            $insert = $activity->insert($_POST);
            requirePage::redirectPage('activity/index');
        }else{
            $errors = $validation->displayErrors();
            twig::render('template/activity/activity-add.twig', ['errors' => $errors, 'activity' => $_POST]);
        }
    }

    public function show($id)
    {

        $activity = new ModelActivity;
        $selectActivity = $activity->selectId($id);
        twig::render('template/activity/activity-show.twig', ['activity' => $selectActivity]);
    }

    public function edit($id)
    {
 
        $activity = new ModelActivity;
        $selectActivity = $activity->selectId($id);
        twig::render('template/activity/activity-edit.twig', ['activity' => $selectActivity]);
    }

    public function update()
    {
        $activity = new ModelActivity;
        $update = $activity->update($_POST);
        requirePage::redirectPage('activity/index');
    }
    public function delete()
    {
        $activity = new ModelActivity;
        $delete = $activity->delete($_POST["id"]);
        requirePage::redirectPage('activity/index');
    }
}
