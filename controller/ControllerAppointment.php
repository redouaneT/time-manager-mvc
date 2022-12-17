<?php
RequirePage::requireModel('Model');
RequirePage::requireModel('ModelAppointment');
RequirePage::requireLibrary('Validation');

class ControllerAppointment
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
        $appointment = new ModelAppointment;
        $select = $appointment->selectByColumnValue('user_id', $_SESSION['user_id']);
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
   
        $validation = new Validation;
        extract($_POST);
        $validation->name('description')->value($description)->required();
        $validation->name('date du rendez-vous')->value($date)->pattern('date_ymd')->required();

        if($validation->isSuccess()){
            $appointment = new ModelAppointment;
            $insert = $appointment->insert($_POST);
            requirePage::redirectPage('appointment/index');
        }else{
            $errors = $validation->displayErrors();
            twig::render('template/appointment/appointment-add.twig', ['errors' => $errors, 'appointment' => $_POST]);
        }
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
