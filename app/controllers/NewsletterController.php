<?php

namespace App\Controllers;

use App\Models\Newsletter;
use App\Models\ForgotPassword;
use App\Core\Request;
use App\Core\App;

class NewsletterController
{


    //check data - login submit
    public function checkData($param)
    {
        //defined variable
        $lang = $param;
        $email = htmlspecialchars($_POST['email']);
        $result = App::get('newsletter')->validateEmail($email);
        $errors = App::get('newsletter')->getError();
        
        //basic validation is ok
        if( count($errors) == 0 )
        {
            //proceed to  check data with db, returns array
            $result = App::get('newsletter')->isUnique($email);
                
            if( count($result) > 0 )
            {
                if( strpos($lang, 'sr') !== false  )
                {
                    $error = '<div class="col-12 alert alert-warning" role="alert"><span>Već ste prijavljeni na naš newsletter!</span></div>';
                }
                elseif( strpos($lang,'en') !== false )
                {
                    $error = '<div class="col-12 alert alert-warning" role="alert"><span>You have already registered for newsletter!</span></div>';
                }

                return view('index',
                [
                    'error' => $error,
                ]
                );
            }
            elseif( count($result) == 0 )
            {
                $selector = bin2hex(random_bytes(8));
                $token = random_bytes(32);
                $hexToken = bin2hex($token);
                $hashedToken = password_hash($token,PASSWORD_DEFAULT);
                $expire = date('U') + 600;

                $url = 'http://saska.local/confirmation/newsletter/%7B' . $selector . '%7D/%7B' .  $hexToken . '%7D/%7B' . $lang . '%7D';
                if( strpos(Request::uri(), 'en') !== false )
                {
                    App::get('newsletter')->storeEmail(  '0', 'en', $email, $selector, $hashedToken, $expire );
                }
                elseif( strpos(Request::uri(), 'sr') !== false )
                {
                    App::get('newsletter')->storeEmail(  '0', 'sr', $email, $selector, $hashedToken, $expire );
                }
                
                $user = App::get('verification')->selectUser($email);
                $user_id = $user[0]->id_email;
                $url_resend = 'http://saska.local/resend/verify/token/%7B' . $user_id . '%7D/%7B' . $lang . '%7D/%7B' . $hexToken . '%7D/%7B' . $selector. '%7D';

                if( strpos($lang, 'sr') !== false  )
                {
                    $successMsg = '<div class="col-12 alert alert-success" role="alert"><span>Primili smo Vaš zahtev, molimo Vas da proverite vaš e-mail kako bi potvrdili prijavu!</span></div>';
                    $subject = "Verifikujte Vaš email - Primljen zahtev za newsletter registraciju(vuk-massage.com)";
                    $message = "<p>Molimo Vas kliknite ovde u narednih 10 minuta: <a href='$url'>$url</a> kako bi potvrdili registraciju na newsletter!</p><br>";
                    $message .= "<p>Ukoliko Vam je isteklo vreme za verifikaciju kliknite ovde: <a href='$url_resend'>$url_resend</a> kako bi rimili novi verifikacioni link!</p><br>";
                    $message .= "<p>Ukoliko se niste vi prijavili, molimo vas ignorišite ovaj email!!!!</p><br>";
                    $message .= "<p>Sve najbolje,</p>";
                    $message .= "<p>Vuk Massage</p>";

                }
                elseif( strpos($lang,'en') !== false )
                {
                    $successMsg = '<div class="col-12 alert alert-success" role="alert"><span>We recived your request, please proceed to your email adress to confirm registration!</span></div>';

                    $subject = "Please verify your email - Recived check in for Newsletter registration vuk-massage.com";
                    $message = "<p>Thanks for contacting us!</p>";
                    $message .= "<p>Please click here in next 10 minutes: <a href='$url'>$url</a> to confirm your registration!</p><br>";
                    $message .= "<p>Click here to resend verification : <a href='$url_resend'>$url_resend</a> to recive new verification link!</p><br>";
                    $message .= "<p>If you haven't registered for our newsletter, please ignore this email!!!!</p><br>";
                    $message .= "<p>Best regards,</p>";
                    $message .= "<p>Vuk Massage</p>";
                }

                App::get('forgot')->sentEmail($email, $subject, $message);

                return view('index',
                [
                    'successMsg' => $successMsg
                ]
                );
            }
        }
        else
        {
            if( strpos($errors['email'], 'empty') !== false )
            {
                if( strpos($lang, 'sr') !== false  )
                {
                    $error= '<div class="col-12 alert alert-warning" role="alert"><span>Unesite Vašu email adresu kako bi ste se prijavili na Newsletter!</span></div>';
                }
                elseif( strpos($lang,'en') !== false )
                {
                    $error = '<div class="col-12 alert alert-warning" role="alert"><span>Enter your email adress in order to check for our Newsletter!</span></div>';
                }
            }
            elseif( strpos($errors['email'], 'valid') !== false )
            {
                if( strpos($lang, 'sr') !== false  )
                {
                    $error = '<div class="col-12 alert alert-warning" role="alert"><span>Email adresa koju ste uneli nije validna!</span></div>';
                }
                elseif( strpos($lang,'en') !== false )
                {
                    $error = '<div class="col-12 alert alert-warning" role="alert"><span>Email adress is not vallid!</span></div>';
                }
            }

            return view('index',
            [
                'error' => $error
            ]
            );
        }
    }  


}

?>