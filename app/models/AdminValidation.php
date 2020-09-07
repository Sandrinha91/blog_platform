<?php

namespace App\Models;

use App\Core\Database\Connection;
use PDO;

class AdminValidation
{
    protected $pdo;
    private $errors = [];

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    //admin validation
    public function adminCheck($table,$username,$mail)
    {
        
        $sql = "SELECT * FROM admin
                WHERE username = :username && email = :email";
        
        try
        {
            $statement = $this->pdo->prepare($sql);
            $statement->execute([':username' => $username, ':email' => $mail]);
            $result = $statement->fetchAll(PDO::FETCH_CLASS);
            $array = $result;
        }
        catch(Exception $e)
        {
            die('Whoops, something went wrong' . $e->getMessage());
        }

        if( count($array) == 1  )
        {
            return true;
        }
        else
        {
            return false;
        }

    }

    //username validation
    public function validateUsername($username)
    {
        
        $val = trim($username);

        if(empty($val))
        {
        $this->addError('username', "<div class='col-12 alert alert-warning' role='alert'><span> Username can't be empty! </span></div>");
        } 
        
        
    }

    // EMAIL VALIDATION
    public function validateEmail($mail)
    {
        $val = trim($mail);

        if(empty($val))
        {
        $this->addError('email', "<div class='col-12 alert alert-warning' role='alert'><span>  E-mail can't be empty! </span></div>");
        } 
        else 
        {
        if(!filter_var($val, FILTER_VALIDATE_EMAIL)){
            $this->addError('email', "<div class='col-12 alert alert-warning' role='alert'><span>  E-mail must be a valid email address! </span></div>");
        }
        }
    }

    // PASSWORD VALIDATION
    public function validatePassword($password)
    {
        $val = trim($password);

        if(empty($val))
        {
            $this->addError('password', "<div class='col-12 alert alert-warning' role='alert'><span>  Password can't be empty! </span></div>");
        } 
        elseif(!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{12,18}$/', $password))
        {
            $this->addError('password', "<div class='col-12 alert alert-warning' role='alert'><span>  Password does not meet the requirements! </span></div>");
        }
        
    }

    // PASSWORD VALIDATION
    public function validatePasswordAdmin($password)
    {
        $val = trim($password);

        if(empty($val))
        {
            $this->addError('password', "<div class='col-12 alert alert-warning' role='alert'><span>  Password can't be empty! </span></div>");
        }         
    }

    // PASSWORD RE-Match
    public function validateMatchPassword($password,$repassword)
    {
        $val = trim($password);
        $val = trim($repassword);

        if($password != $repassword)
        {
            $this->addError('re-password', "<div class='col-12 alert alert-warning' role='alert'><span>  Password does not match! </span></div>");
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

    //returns login attempts
    public function getStrike($table)
    {
        $sql = "SELECT atempt FROM admin;";

        try
        {
            $statement = $this->pdo->prepare($sql);
            $statement->execute();
            $count = $statement->fetchAll(PDO::FETCH_CLASS);
            $result = $count[0];
            return $result;
        }
        catch(Exception $e)
        {
            die('Whoops, something went wrong' . $e->getMessage());
        }
    }

    //return admin_pwd from table
    public function getPwd($email, $username)
    {
        $sql = "SELECT password FROM admin
                WHERE email = :email and username = :username;";

        try
        {
            $statement = $this->pdo->prepare($sql);
            $statement->execute([':email' => $email , ':username' => $username]);
            $count = $statement->fetchAll(PDO::FETCH_CLASS);
            $result = $count[0]->password;
            return $result;
        }
        catch(Exception $e)
        {
            die('Whoops, something went wrong' . $e->getMessage());
        }
    }

    //return time from table
    public function getTime($table)
    {
        $sql = "SELECT time FROM admin;";

        try
        {
            $statement = $this->pdo->prepare($sql);
            $statement->execute();
            $count = $statement->fetchAll(PDO::FETCH_CLASS);
            $result = $count[0];
            return $result;
        }
        catch(Exception $e)
        {
            die('Whoops, something went wrong' . $e->getMessage());
        }
    }

    //update login attempts to 0 after 15 min
    public function updateStrike($counter)
    {
        $sql = "UPDATE admin SET atempt = :atempt WHERE username = :username";
        
        try
        {
            $statement = $this->pdo->prepare($sql);
            $statement->execute([':atempt' => $counter, ':username' => 'AngelOzzyVuk90']);
        }
        catch(Exception $e)
        {
            die('Whoops, something went wrong' . $e->getMessage());
        }
    }

    //update time after 15 min
    public function updateTime($time)
    {
        $sql = "UPDATE admin SET time = :time WHERE username = :username";
        
        try
        {
            $statement = $this->pdo->prepare($sql);
            $statement->execute([':time' => $time, ':username' => 'AngelOzzyVuk90']);
        }
        catch(Exception $e)
        {
            die('Whoops, something went wrong' . $e->getMessage());
        }
    }

    //set admin key
    public function setKey($value, $username)
    {
        $sql = "UPDATE admin SET admin_key_value = :admin_key_value WHERE username = :username";
        
        try
        {
            $statement = $this->pdo->prepare($sql);
            $statement->execute([':admin_key_value' => $value, ':username' => $username]);
        }
        catch(Exception $e)
        {
            die('Whoops, something went wrong' . $e->getMessage());
        }
    }

    //set admin isAdmin
    public function setIsAdmin( $value, $username, $adminTime )
    {
        $sql = "UPDATE admin SET is_admin = :is_admin, admin_session_time = :admin_session_time WHERE username = :username";
        
        try
        {
            $statement = $this->pdo->prepare($sql);
            $statement->execute([':is_admin' => $value, ':username' => $username, ':admin_session_time' => $adminTime]);
        }
        catch(Exception $e)
        {
            die('Whoops, something went wrong' . $e->getMessage());
        }
    }

}

?>