<?php
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\SMTP;

//    require '../vendor/autoload.php';

class Mailer
{
    static public function send($emailfrom, $emailto, $subject, $body){

        //Create a new PHPMailer instance
        $mail = new PHPMailer(true);

        try{
            //Tell PHPMailer to use SMTP
            $mail->isSMTP();
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            //Set the hostname of the mail server
            $mail->Host = 'smtp.sendgrid.net';
            $mail->SMTPAuth   = true;
            $mail->Username   = '';
            $mail->Password   = ''; 
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;
    
                //Recipients
            $mail->setFrom($emailfrom);
            $mail->addAddress($emailto);     //Add a recipient
            $mail->addReplyTo($emailfrom);
            // $mail->addCC('cc@example.com');
            // $mail->addBCC('bcc@example.com');
                //Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
    
             //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $body;
            // $mail->AltBody = $AltBody;
    
            $mail->send();
            return "<ul><li>Le message à été envoyé!</li></ul>";
        }catch (Exception $e) {
            // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            return "<ul><li>L'envoi du message à échoué!</li></ul>";
        }
    }
}
