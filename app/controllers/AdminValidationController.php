<?php

namespace App\Controllers;

//use App\Models\Admin;
use App\Core\Request;
use App\Core\App;

class AdminValidationController
{

    //check data - login submit
    public function checkData($param)
    {
        //defined variable
        $username = htmlspecialchars($_POST['username']);
        $mail = htmlspecialchars($_POST['mail']);
        $password = htmlspecialchars($_POST['password']);

        $count = App::get('admin')->getStrike('admin');
        $counter = (int)$count->atempt;

        if( $counter > 0 )
        {
            //field input validation, it returns array errors
            App::get('admin')->validateUsername($username);
            App::get('admin')->validateEmail($mail);
            App::get('admin')->validatePasswordAdmin($password );
            $errors = App::get('admin')->getError();

            //basic validation is ok
            if( count($errors) == 0 )
            {
                //proceed to  check data with db, returns true or false
                $result = App::get('admin')->adminCheck('admin', $username, $mail);

                if( $result !== false )
                {
                    $passDb = App::get('admin')->getPwd($mail, $username);

                    if( password_verify($password, $passDb) !== false )
                    {
                        //set admin value key
                        $hash = password_hash($username, PASSWORD_DEFAULT);
                        App::get('admin')->setKey($hash, $username);
                        //set is_admin na true -set admin session time
                        $time = time();
                        $adminTime = $time + 3600;
                        App::get('admin')->setIsAdmin(true, $username, $adminTime);

                        return view('admin',
                        [
                            'username' => $username,
                        ]
                        );
                    }
                    else
                    {
                        $error = '<div class="col-12 alert alert-warning" role="alert"><span>Invalid pasword, username or email adress!</span></div>';
                        $counter1 = $counter - 1;
                        $counter = '<div class="col-12 alert alert-warning" role="alert">You have: ' . $counter1 .  ' attempts left!</div>';
                        App::get('admin')->updateStrike($counter1);

                        return view('login',
                        [
                            'error' => $error,
                            'counter' => $counter,
                        ]
                        );
                    }
                }
                else
                {
                    $error = '<div class="col-12 alert alert-warning" role="alert"><span>Invalid pasword, username or email adress!</span></div>';
                    $counter1 = $counter - 1;
                    $counter = '<div class="col-12 alert alert-warning" role="alert">You have: ' . $counter1 .  ' attempts left!</div>';
                    App::get('admin')->updateStrike($counter1);

                    return view('login',
                    [
                        'error' => $error,
                        'counter' => $counter,
                    ]
                    );  
                }
            }
            elseif( count($errors) != 0 )
            {
                $counter = $counter - 1;
                App::get('admin')->updateStrike($counter);
                $counter = '<div class="col-12 alert alert-warning" role="alert">You have: ' . $counter .  ' attempts left!</div>';

                return view('login',
                    [
                        'errors' => $errors,
                        'counter' => $counter,
                    ]
                    );   
            }
        }
        else
        {
            $timer= App::get('admin')->getTime('admin');
            $timerA = (int)$timer->time;
            $breakPoint = $timerA + 300;
            $curentTime = date('U');
            $curentT = (int)$curentTime;
    
            if( $timerA == 0 )
            {
                $curentTime = date('U');
                App::get('admin')->updateTime($curentTime);
                $curentT = (int)$curentTime;
                $count = App::get('admin')->getStrike('admin');
                $counter = (int)$count->atempt;
                $error = '<div class="col-12 alert alert-warning" role="alert"><span> Wait 5 min to reload! </span></div>';
                $counter = '<div class="col-12 alert alert-warning" role="alert">You have: ' . $counter .  ' attempts left!</div>';
    
                return view('login',
                    [
                        'counter' => $counter,
                        'error' => $error,
                    ]
                    ); 
            }
            elseif( $breakPoint <= $curentT && $breakPoint != 300)
            {
                App::get('admin')->updateStrike(3);
                App::get('admin')->updateTime(0);
                $count = App::get('admin')->getStrike('admin');
                $counter = (int)$count->atempt;
                $counter = '<div class="col-12 alert alert-warning" role="alert">You have: ' . $counter .  ' attempts left!</div>';
                $refresh = '<div class="col-12 alert alert-warning" role="alert">Page refreshed!</div>';
    
                return view('login',
                    [
                        'counter' => $counter,
                        'refresh' => $refresh,
                    ]
                    ); 
            }
            else
            {
                $error = '<div class="col-12 alert alert-warning" role="alert">Wait 5 min to reload!</div>';
    
                return view('login',
                    [
                        'error' => $error,
                    ]
                    ); 
            }
        }
        
    }  
}

?>