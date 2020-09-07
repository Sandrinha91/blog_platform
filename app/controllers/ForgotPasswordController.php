<?php

namespace App\Controllers;

//use App\Models\Admin;
use App\Core\Request;
use App\Core\App;
use App\Models\AdminValidation;

class ForgotPasswordController
{
    //returns form for insert recover email adress
    public function formView()
    {
        return view('email');

    }

    //returns form for insert new password adress
    public function enterNewPass($value)
    {
        $validator = $value[3];
        $selector = $value[1];

        if( empty($selector) || empty($validator) )
        {
            return view('pagenotfound');
        }
        else
        {
            if( ctype_xdigit($selector) !== false &&  ctype_xdigit($validator) !== false)
            {
                return view('changepass',
                    [
                        'selector' => $selector,
                        'validator' => $validator,
                    ]
                    );
            }
        }   
    }

    //checks email data form, create token
    public function checkData()
    {
        //defined variable
        $email = htmlspecialchars($_POST['email']);

        App::get('admin')->validateEmail($email);
        $errors = App::get('admin')->getError();

        if( count($errors) == 0 )
        {
            App::get('forgot')->removeToken($email);
            $selector = bin2hex(random_bytes(8));
            $token = random_bytes(32);
            $hexToken = bin2hex($token);
            $hashedToken = password_hash($token,PASSWORD_DEFAULT);
            $expire = date('U') + 600;

            $url = 'http://saska.local/cant/rememberpwd/%7B' . $selector . '%7D/%7B' .  $hexToken . '%7D';

            $message = "<p>We recived a password reset request. The link to reset your password is bellow. 
                        If you did not make this request, you can ignore this email.</p>";
            $message .= "<p>Here is your password reset link: <br>";
            $message .= "<a href='" . $url . "'>" . $url . "</a></p>";
            $subject = 'Reset your password for vuk_masaza';
            App::get('forgot')->storeToken($email, $selector, $hashedToken, $expire);
            App::get('forgot')->sentEmail($email, $subject, $message);
            $success = '<div class="col-12 alert alert-success" role="alert"><span>Check your e-mail!!!</span></div>';

            return redirect('password/forgot',
                [
                    'success' => $success,
                ]
                );
        }
        elseif(  count($errors) > 0 )
        {
            return view('email',
                [
                    'errors' => $errors,
                ]
                );
        }
    }

    //check data from password change form
    public function checkPass()
    {
        //defined variable
        $selector = htmlspecialchars($_POST['selector']);
        $validator = htmlspecialchars($_POST['validator']);
        $password = htmlspecialchars($_POST['pwd']);
        $repassword = htmlspecialchars($_POST['re_pwd']);
        //var_dump($repassword);

        App::get('admin')->validatePassword($password);
        App::get('admin')->validateMatchPassword($password,$repassword);
        
        $errors = App::get('admin')->getError();
        
        if( count($errors) == 0 )
        {
            $curentTime = date('U');
            $result = App::get('forgot')->selectSelector($selector, $curentTime);

            if( count( $result ) == 0 )
            {
                return view('pagenotfound');
            }
            else
            {
                $tokenBin = hex2bin($validator);
                $tokenCheck = password_verify($tokenBin, $result[0]->pwd_reset_token);
               
                if( $tokenCheck !== true )
                {
                    return view('pagenotfound');
                }
                elseif( $tokenCheck !== false )
                {
                    $tokenEmail = $result[0]->pwd_reset_email;
                    $user = App::get('forgot')->selectUser($tokenEmail);

                    if( count( $user ) == 0 )
                    {
                        return view('pagenotfound');
                    }
                    elseif( count( $user ) > 0 )
                    {
                        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                        //update password
                        App::get('forgot')->updatePass( $passwordHash, $tokenEmail );
                        //erase token
                        App::get('forgot')->removeToken($tokenEmail);

                        $loginMsg = '<div class="col-12 alert alert-success" role="alert">Login with new password!!!</div>';

                        //sent to login page
                        return view('login',
                            [
                                'loginMsg' => $loginMsg,
                            ]
                            );
                    }
                }
            }
        }
        else
        {
            return view('changepass',
                [
                    'selector' => $selector,
                    'validator' => $validator,
                    'errors' => $errors,
                ]
                );
        }
    }  


}

?>