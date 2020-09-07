<?php

namespace App\Controllers;

//use App\Models\Admin;
use App\Core\Request;
use App\Core\App;
use App\Models\UserContactValidation;
use App\Models\ForgotPassword;

class UserContactController
{
    //check data
    public function checkMsgData($param)
    {
        //defined variable
        $lang = $param;
        $email = htmlspecialchars($_POST['email']);
        $message_user = htmlspecialchars($_POST['message']);
    
        App::get('user')->validateUserMessage($message_user,$lang);
        App::get('user')->validateUserEmail($email,$lang);

        $errors =  App::get('user')->getError();
        
        //basic validation is ok
        if( count($errors) == 0 )
        {
            if( strpos($lang, 'en') !== false  )
            {
                $subject = "Success,message recived!!!";
                $message = "<p>Thanks for contacting us!</p>";
                $message .= "<p>We recived your message. We will answer as soon as possible!</p><br>";
                $message .= "<p>Best regards,</p>";
                $message .= "<p>Vuk Massage</p>";

                App::get('forgot')->sentEmail($email, $subject, $message);

                $subject_admin = "New message from website visitor!!!";
                $message_admin = "<p>From: $email</p>";
                $message_admin .= "<p>$message_user</p>";
                $email_admin = 'aleksandragrujic91@gmail.com';
                
                App::get('forgot')->sentEmail($email_admin, $subject_admin, $message_admin);
            }
            elseif( strpos($lang,'sr') !== false )
            {
                $subject = "Čestitamo,vaša poruka je primljena!!!";
                $message = "<p>Hvala što ste nas kontaktirali!</p>";
                $message .= "<p>Odgovorićemo na vaš zahtev u što kraćem roku!</p><br>";
                $message .= "<p>Srdačan poydrav,</p>";
                $message .= "<p>Vuk Massage</p>";

                App::get('forgot')->sentEmail($email, $subject, $message);

                $subject_admin = "Primili ste novu poruku od korisnika sa vašeg website-a!!!";
                $message_admin = "<p>$message_user</p>";
                $email_admin = 'aleksandragrujic91@gmail.com';
                
                App::get('forgot')->sentEmail($email_admin, $subject_admin, $message_admin);
            }

            return redirect('homepage/{$lang}');
        }
        else
        {
            return view('index',
            [
                'errors' => $errors
            ]
            );
        }       
        
    }  


}

?>