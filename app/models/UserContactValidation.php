<?php

namespace App\Models;

use App\Core\Database\Connection;
use PDO;

class UserContactValidation
{
    protected $pdo;
    private $errors = [];

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    //username validation
    public function validateUserMessage($message,$lang)
    {
        $val = trim($message);

        if(empty($val))
        {
            if( strpos($lang, 'sr') !== false  )
            {
                $this->addError('message', '<div class="col-12 alert alert-warning" role="alert"><span>Unesite Vašu poruku kako bi nam poslalo email!</span></div>');
                //$errors= '<div class="col-12 alert alert-warning" role="alert"><span>Unesite Vašu poruku kako bi nam poslalo email!</span></div>';
            }
            elseif( strpos($lang,'en') !== false )
            {
                $this->addError('message', '<div class="col-12 alert alert-warning" role="alert"><span>Enter your message in order to send us an email!</span></div>');
                //$errors = '<div class="col-12 alert alert-warning" role="alert"><span>Enter your message in order to send us an email!</span></div>';
            }
        }    
    }

    // EMAIL VALIDATION
    public function validateUserEmail($mail,$lang)
    {
        $val = trim($mail);

        if(empty($val))
        {
            if( strpos($lang, 'sr') !== false  )
            {
                $this->addError('e_mail', '<div class="col-12 alert alert-warning" role="alert"><span>Unesite Vašu email adresu kako bi poslali poruku!</span></div>');
            }
            elseif( strpos($lang,'en') !== false )
            {
                $this->addError('e_mail', '<div class="col-12 alert alert-warning" role="alert"><span>Enter your email adress in order to send us an email!</span></div>');
            }
        
        } 
        else 
        {
            if(!filter_var($val, FILTER_VALIDATE_EMAIL))
            {
                if( strpos($lang, 'sr') !== false  )
                {
                    $this->addError('email_val', '<div class="col-12 alert alert-warning" role="alert"><span>Email adresa koju ste uneli nije validna!</span></div>');
                }
                elseif( strpos($lang,'en') !== false )
                {
                    $this->addError('email_val', '<div class="col-12 alert alert-warning" role="alert"><span>Email adress is not vallid!</span></div>');
                }
                
            }
        }
    }

    //FUNCTION FOR ARRAY OF ERRORS(if some validation block code register an error, the same is added to array)
    public function addError($key, $val)
    {
        $this->errors[$key] = $val;
    }

    public function getError()
    {
        return $this->errors;
    }

}

?>