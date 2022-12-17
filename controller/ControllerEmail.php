<?php
RequirePage::requireLibrary('Validation');
RequirePage::requireModel('Model');
RequirePage::requireModel('ModelUser');

class ControllerEmail
{
    public function __construct()
    {
        CheckSession::sessionAuth();

    }
    public function create()
    {   

        twig::render('template/email/email-create.twig');
        
    }
    public function send()
    {   
        $validation = new Validation;
        extract($_POST);
        $validation->name('de la prt de ')->value($emailfrom)->pattern('email')->required()->max(50);
        $validation->name('envoyer à')->value($emailto)->pattern('email')->required()->max(50);
        $validation->name('Objet')->value($subject)->required();
        $validation->name('message')->value($message)->required();

        if($validation->isSuccess()){

     
            $result = Mailer::send($emailfrom, $emailto, $subject, $message);
            twig::render('template/email/email-create.twig', ['response' => $result]);
        }else{
            $errors = $validation->displayErrors();
            twig::render('template/email/email-create.twig', ['response' => $errors]);
        }
    }
    public function sendToClient()
    {   
        $validation = new Validation;
        extract($_POST);
        $validation->name('courriel')->value($emailto)->pattern('email')->required()->max(50);
        $validation->name('Objet')->value($subject)->required();
        $validation->name('message')->value($message)->required();

        if($validation->isSuccess()){
            $emailfrom = $_SESSION["email"];
            $result = Mailer::send($emailfrom, $emailto, $subject, $message);
            twig::render('template/client/client-contact.twig', ['response' => $result]);
        }else{
            $errors = $validation->displayErrors();
            twig::render('template/client/client-contact.twig', ['response' => $errors]);
        }
    }
}