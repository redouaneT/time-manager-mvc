<?php
RequirePage::requireModel('Model');
RequirePage::requireModel('ModelAppointment');

class ControllerAppointment
{
    public function __construct()
    {
        $_POST["user_id"] = 1;
    }

    public function index()
    {
        $appointment = new ModelAppointment;
        $select = $appointment->select();
        twig::render('template/appointment/appointment-index.twig', [
            'appointments' => $select,
            'appointment_list' => "Liste de Appointment"
        ]);
    }

    public function add()
    {
        twig::render('template/appointment/appointment-add.twig');
    }

    public function store()
    {
        // print_r($_POST);
        $appointment = new ModelAppointment;
        $insert = $appointment->insert($_POST);
        requirePage::redirectPage('appointment/index');
    }

    public function show($id)
    {
        $appointment = new ModelAppointment;
        $selectAppointment = $appointment->selectId($id);
        twig::render('template/appointment/appointment-show.twig', ['appointment' => $selectAppointment]);
    }

    public function edit($id)
    {
        $appointment = new ModelAppointment;
        $selectAppointment = $appointment->selectId($id);
        twig::render('template/appointment/appointment-edit.twig', ['appointment' => $selectAppointment]);
    }

    public function update()
    {
        $appointment = new ModelAppointment;
        $update = $appointment->update($_POST);
        requirePage::redirectPage('appointment/index');
    }
    public function delete()
    {
        $appointment = new ModelAppointment;
        $delete = $appointment->delete($_POST["id"]);
        requirePage::redirectPage('appointment/index');
    }
}
