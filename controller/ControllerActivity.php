<?php
RequirePage::requireModel('Model');
RequirePage::requireModel('ModelActivity');

class ControllerActivity
{
    public function __construct()
    {
        $_POST["user_id"] = 1;
    }

    public function index()
    {
        $activity = new ModelActivity;
        $select = $activity->select();
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
        // print_r($_POST);
        $activity = new ModelActivity;
        $insert = $activity->insert($_POST);
        requirePage::redirectPage('activity/index');
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
