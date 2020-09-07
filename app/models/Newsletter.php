<?php

namespace App\Models;

use App\Core\Database\Connection;
use PDO;
use App\Core\App;

class Newsletter
{
    protected $pdo;
    private $errors = [];

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }


    // EMAIL VALIDATION
    public function validateEmail($mail)
    {
        $val = trim($mail);

        if(empty($val))
        {
            $this->addError('email', 'Email cannot be empty!');
        }
        else 
        {
            if(!filter_var($val, FILTER_VALIDATE_EMAIL))
            {
                $this->addError('email', 'Email must be a valid email address!');
            }
        }
    }
        
    //FUNCTION FOR ARRAY OF ERRORS(if some validation block code register an error, the same is added to array)
    private function addError($key, $val)
    {
        $this->errors[$key] = $val;
    }

    public function getError()
    {
        return $this->errors;
    }

    //check if email is unique
    public function isUnique($email)
    {
        
        $sql = "SELECT email
                FROM newsletter_list
                WHERE email = :email;";
        
        
        try
        {
            $statement = $this->pdo->prepare($sql);
            $statement->execute([':email' => $email]);
            $result = $statement->fetchAll(PDO::FETCH_CLASS);
            return $result;
        }
        catch(Exception $e)
        {
            die('Whoops, something went wrong' . $e->getMessage());
        }
    }

    //insert new email in newssleter
    public function storeEmail($emailSt, $lang ,$email,$selector,$validator,$timeToken )
    {
        
        $sql = "INSERT INTO newsletter_list (email_status, enail_language , email, s_key, v_key, v_time_expires)
                VALUES (:email_status, :enail_language ,:email, :s_key, :v_key, :v_time_expires);";
        
        try
        {
            $statement = $this->pdo->prepare($sql);
            $statement->execute([':email_status' => $emailSt, ':enail_language' => $lang, ':email' => $email, ':s_key' => $selector, ':v_key' => $validator, ':v_time_expires' => $timeToken]);
        }
        catch(Exception $e)
        {
            die('Whoops, something went wrong' . $e->getMessage());
        }
    }
    //COUNT email from newsletter with limit
    public function countEmails()
    {
        $sql = "SELECT COUNT(id_email) AS NumberOfPost FROM newsletter_list;";
        
        try
        {
            $statement = $this->pdo->prepare($sql);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_CLASS);
            $result = (int)$result[0]->NumberOfPost;
            return $result;
        }
        catch(Exception $e)
        {
            die('Whoops, something went wrong' . $e->getMessage());
        }
    }

    //select email from newsletter with limit
    public function getEmailList($downLimit,$upLimit)
    {
        $sql = "SELECT * 
                FROM newsletter_list
                ORDER BY register_on DESC
                LIMIT $downLimit,$upLimit;";
        
        try
        {
            $statement = $this->pdo->prepare($sql);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_CLASS);
            return $result;
        }
        catch(Exception $e)
        {
            die('Whoops, something went wrong' . $e->getMessage());
        }
    }

    //delete email in newssleter
    public function deleteEmailById($id)
    {
        $sql = "DELETE FROM newsletter_list
                WHERE id_email = :id_email;"; 
        
        try
        {
            $statement = $this->pdo->prepare($sql);
            $statement->execute([':id_email' => $id]);
        }
        catch(Exception $e)
        {
            die('Whoops, something went wrong' . $e->getMessage());
        }
    }

    public function updateEmailExpire($id_email, $lang, $expire)
    {
        $sql = "UPDATE newsletter_list 
                SET v_time_expires = :v_time_expires  
                WHERE id_email = :id_email AND enail_language = :enail_language";
        
        try
        {
            $statement = $this->pdo->prepare($sql);
            $statement->execute([':v_time_expires' => $expire, ':id_email' => $id_email, ':enail_language' => $lang]);
        }
        catch(Exception $e)
        {
            die('Whoops, something went wrong' . $e->getMessage());
        }
    }

}

?>