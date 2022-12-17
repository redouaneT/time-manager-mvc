<?php
RequirePage::requireModel('Model');
RequirePage::requireModel('ModelNote');
RequirePage::requireLibrary('Validation');

class ControllerNote
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
        $note = new ModelNote;
        $select =  $note->selectByColumnValue('user_id', $_SESSION['user_id'] );
        twig::render('template/note/note-index.twig', [
            'notes' => $select,
            'note_list' => "Liste de Note"
        ]);
    }

    public function add()
    {
        twig::render('template/note/note-add.twig');
    }

    public function store()
    {
            $validation = new Validation;
            extract($_POST);
            $validation->name('titre')->value($title)->required()->max(255);

            if($validation->isSuccess()){
                $note = new ModelNote;
                $insert =  $note->insert($_POST);
                requirePage::redirectPage('note/index');
            }else{

                $errors = $validation->displayErrors();
                twig::render('template/note/note-add.twig', ['errors' => $errors, 'note' => $_POST]);
            }
    }

    public function show($id)
    {
        $note = new ModelNote;
        $selectNote =  $note->selectId($id);
        twig::render('template/note/note-show.twig', ['note' => $selectNote]);
    }

    public function edit($id)
    {
        $note = new ModelNote;
        $selectNote =  $note->selectId($id);
        twig::render('template/note/note-edit.twig', ['note' => $selectNote]);
    }

    public function update()
    {
        $note = new ModelNote;
        $update =  $note->update($_POST);
        requirePage::redirectPage('note/index');
    }
    public function delete()
    {
        $note = new ModelNote;
        $delete =  $note->delete($_POST["id"]);
        requirePage::redirectPage('note/index');
    }
}
