<?php
RequirePage::requireModel('Model');
RequirePage::requireModel('ModelNote');

class ControllerNote
{
    public function __construct()
    {
        $_POST["user_id"] = 1;
    }

    public function index()
    {
        $note = new ModelNote;
        $select =  $note->select();
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
        $note = new ModelNote;
        $insert =  $note->insert($_POST);
        requirePage::redirectPage('note/index');
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
