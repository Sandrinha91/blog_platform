<?php

namespace App\Models;

use App\Core\Database\Connection;
use PDO;
//Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class Verification
{
    protected $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    //select selector == $selector
    public function selectSelector($selector, $curentTime)
    {
        $sql = "SELECT * FROM newsletter_list WHERE s_key = :s_key AND v_time_expires >= :v_time_expires";
        
        try
        {
            $statement = $this->pdo->prepare($sql);
            $statement->execute([':s_key' => $selector, ':v_time_expires' => $curentTime]);
            $result = $statement->fetchAll(PDO::FETCH_CLASS);
            return $result;
        }
        catch(Exception $e)
        {
            die('Whoops, something went wrong' . $e->getMessage());
        }
    }

    //select user from newsletter table where email = $tokenemail
    public function selectUser($tokenEmail)
    {
        $sql = "SELECT * FROM newsletter_list WHERE email = :email";
        
        try
        {
            $statement = $this->pdo->prepare($sql);
            $statement->execute([':email' => $tokenEmail]);
            $result = $statement->fetchAll(PDO::FETCH_CLASS);
            return $result;
        }
        catch(Exception $e)
        {
            die('Whoops, something went wrong' . $e->getMessage());
        }
    }

    //select user from newsletter table email id and language
    public function selectUserById($id, $lang)
    {
        $sql = "SELECT * FROM newsletter_list 
                WHERE id_email = :id_email AND enail_language = :enail_language";
        
        try
        {
            $statement = $this->pdo->prepare($sql);
            $statement->execute([':id_email' => $id, ':enail_language' => $lang]);
            $result = $statement->fetchAll(PDO::FETCH_CLASS);
            return $result;
        }
        catch(Exception $e)
        {
            die('Whoops, something went wrong' . $e->getMessage());
        }
    }

    //verify email adress set 0  to 1
    public function updateEmailStatus( $bool, $email )
    {
        $sql = "UPDATE newsletter_list SET email_status = :email_status WHERE email = :email";
        
        try
        {
            $statement = $this->pdo->prepare($sql);
            $statement->execute([':email_status' => $bool, ':email' => $email]);
        }
        catch(Exception $e)
        {
            die('Whoops, something went wrong' . $e->getMessage());
        }
    }

    //select/prepare user for unsuscribe user from newsletter list list 
    public function selectUserForUnsuscribe( $id, $selector, $validator )
    {
        $sql = "SELECT * FROM newsletter_list 
                WHERE id_email = :id_email AND s_key = :s_key AND v_key=:v_key ";
        
        try
        {
            $statement = $this->pdo->prepare($sql);
            $statement->execute([':id_email' => $id, ':s_key' => $selector, ':v_key' => $validator]);
            $result = $statement->fetchAll(PDO::FETCH_CLASS);
            return $result;
        }
        catch(Exception $e)
        {
            die('Whoops, something went wrong' . $e->getMessage());
        }
    }

    //select/prepare user for unsuscribe user from newsletter list list 
    public function unsuscribeMe( $id, $selector)
    {
        $sql = "DELETE FROM newsletter_list 
                WHERE id_email = :id_email AND s_key = :s_key";
        
        try
        {
            $statement = $this->pdo->prepare($sql);
            $statement->execute([':id_email' => $id, ':s_key' => $selector]);
        }
        catch(Exception $e)
        {
            die('Whoops, something went wrong' . $e->getMessage());
        }
    }
}

?>