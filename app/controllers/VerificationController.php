<?php

namespace App\Controllers;

//use App\Models\Admin;
use App\Core\Request;
use App\Core\App;
use App\Models\AdminValidation;
use App\Models\ForgotPassword;
use App\Models\Newsletter;

class VerificationController
{

    //check data for email verification
    public function checkData($value)
    {
        //defined variable
        $selector = $value[1];
        $validator = $value[3];
        $lang = $value[5];

        $curentTime = date('U');
        $result = App::get('verification')->selectSelector($selector, $curentTime);

        if( count( $result ) == 0 )
        {
            return view('pagenotfound');
        }
        else
        {
            $tokenBin = hex2bin($validator);
            $tokenCheck = password_verify($tokenBin, $result[0]->v_key);

            if( $tokenCheck !== true )
            {
                return view('pagenotfound');
            }
            elseif( $tokenCheck !== false )
            {
                if( $curentTime <= $result[0]->v_time_expires )
                {
                    $tokenEmail = $result[0]->email;
                    $user = App::get('verification')->selectUser($tokenEmail);
                    var_dump($user);

                    if( count( $user ) == 0 )
                    {
                        return view('pagenotfound');
                    }
                    elseif( count( $user ) > 0 )
                    {
                        //verify email
                        App::get('verification')->updateEmailStatus( '1', $tokenEmail );

                        $id = $user[0]->id_email;
                        $s_key = $user[0]->s_key;
                        $v_key = bin2hex($user[0]->v_key);
                        $url = 'http://saska.local/unsuscribe/me/%7B' . $id . '%7D/%7B' . $s_key . '%7D/%7B' . $v_key . '%7D/%7B' . $lang . '%7D';

                        if( strpos($lang, 'sr') !== false  )
                        {

                            $subject = "Čestitamo, registracija potvrdjena(vuk-massage.com)";
                            $message = "<p>Obaveštavaćemo Vas o novostima!</p><br>";
                            $message .= "<p>Hvala na poverenju!</p><br>";
                            $message .= "<p>Sve najbolje,</p>";
                            $message .= "<p>Vuk Massage</p>";
                            $message .= "<hr>";
                            $message .= "<p>Želite da se odjavite sa Newsletter? Kliknite ovde: <a href='http://saska.local/unsuscribe/me/%7B$id%7D/%7B$s_key%7D/%7B$v_key%7D/%7B$lang%7D'>$url</a> kako bi se odjavili sa naše liste.</p>";

                            //send confirmed verification
                            App::get('forgot')->sentEmail($user[0]->email, $subject, $message);

                            //redirect to index
                            return redirect('homepage/%7Bsr%7D#newsletter');

                        }
                        elseif( strpos($lang,'en') !== false )
                        {
                            $subject = "Success! You have registered for vuk-massage.com";
                            $message = "<p>We will notify you about news!</p>";
                            $message .= "<p>Thanks for the thrust!</p><br>";
                            $message .= "<p>Best regards,</p>";
                            $message .= "<p>Vuk Massage</p>";
                            $message .= "<hr>";
                            $message .= "<p>Click <a href='http://saska.local/unsuscribe/me/%7B$id%7D/%7B$s_key%7D/%7B$v_key%7D/%7B$lang%7D'>$url</a> for Unsucribe.</p>";

                            //send confirmed verification
                            App::get('forgot')->sentEmail($user[0]->email, $subject, $message);

                            //redirect to index
                            return redirect('homepage/%7Ben%7D#newsletter');
                        }   
                    }
                }
            }   
        }
    }

    public function ResendVerificationLink($value)
    {
        $id = $value[1];
        $lang = $value[3];
        $hexToken = $value[5];
        $selector = $value[7];

        $result = App::get('verification')->selectUserById($id, $lang);

        if( count($result) == 1 )
        {
            if( $result[0]->email_status == 0 )
            {
                $expire = date('U') + 600;
                App::get('newsletter')->updateEmailExpire(  $result[0]->id_email, $lang, $expire );
                // $newExpire = App::get('verification')->selectUserById($id, $lang);

                $url = 'http://saska.local/confirmation/newsletter/%7B' . $selector . '%7D/%7B' .  $hexToken . '%7D/%7B' . $lang . '%7D';
                $url_resend = 'http://saska.local/resend/verify/token/%7B' . $id . '%7D/%7B' . $lang . '%7D/%7B' . $hexToken . '%7D/%7B' . $selector. '%7D';

                if( strpos($lang, 'sr') !== false  )
                {
                    $successMsg = '<div class="col-12 alert alert-success" role="alert"><span>Verifikujte Vaš email - Primljen zahtev za newsletter registraciju(vuk-massage.com)</span></div>';
                    $subject = "Verifikujte Vaš email - Primljen zahtev za newsletter registraciju(vuk-massage.com)";
                    $message = "<p>Molimo Vas kliknite ovde u narednih 10 minuta: <a href='$url'>$url</a> kako bi potvrdili registraciju na newsletter!</p><br>";
                    $message .= "<p>Ukoliko Vam je isteklo vreme za verifikaciju kliknite ovde: <a href='$url_resend'>$url_resend</a> kako bi rimili novi verifikacioni link!</p><br>";
                    $message .= "<p>Ukoliko se niste vi prijavili, molimo vas ignorišite ovaj email!!!!</p><br>";
                    $message .= "<p>Sve najbolje,</p>";
                    $message .= "<p>Vuk Massage</p>";

                    App::get('forgot')->sentEmail($result[0]->email, $subject, $message);
                    return redirect('homepage/%7Bsr%7D');

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

                    App::get('forgot')->sentEmail($result[0]->email, $subject, $message);
                    return redirect('homepage/%7Ben%7D');
                }
            }
            else
            {
                return view('pagenotfound');
            }
        }
        else
        {
            return view('pagenotfound');
        }
    }

    public function unsuscribeMe($value)
    {
        //defined variable
        $id = $value[1];
        $selector = $value[3];
        $validator = $value[5];
        $lang = $value[7];
        $tokenBin = hex2bin($validator);

        $result = App::get('verification')->selectUserForUnsuscribe($id, $selector, $tokenBin);

        if( count($result) == 0 )
        {
            return view('pagenotfound');
        }
        elseif( count($result) == 1 )
        {
            App::get('verification')->unsuscribeMe($id, $selector);


            if( strpos($lang, 'sr') !== false  )
            {

                $subject = "Uklonjeni ste sa naše newsletter liste(vuk-massage.com)";
                $message = "<p>Uklonjeni ste sa naše newsletter liste!</p><br>";
                $message .= "<p>Sve najbolje,</p>";
                $message .= "<p>Vuk Massage</p>";

                //send confirmed verification
                App::get('forgot')->sentEmail($result[0]->email, $subject, $message);

                //redirect to index
                return redirect('homepage/%7Bsr%7D');

            }
            elseif( strpos($lang,'en') !== false )
            {
                $subject = "Successfull Unsuscribe(vuk-massage.com)";
                $message = "<p>You are no longer on our list!</p><br>";
                $message .= "<p>Best regards,</p>";
                $message .= "<p>Vuk Massage</p>";

                //send confirmed verification
                App::get('forgot')->sentEmail($result[0]->email, $subject, $message);

                //redirect to index
                return redirect('homepage/%7Ben%7D');
            } 
        }
    }
}

?>