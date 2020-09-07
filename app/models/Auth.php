<?php

namespace App\Models;

use App\Core\Database\Connection;
use PDO;
use App\Core\App;

class Auth
{
    protected $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    //store is_admin boolean
    private function storeIsAdmin($name, $username)
    {
        $sql = "UPDATE admin SET is_admin = :is_admin WHERE username = :username";
        try
        {
            $statement = $this->pdo->prepare($sql);
            $statement->execute([':is_admin' => $name, ':username' => $username]);
        }
        catch(Exception $e)
        {
            die('Whoops, something went wrong' . $e->getMessage());
        }
    }

    // returns is_admin boolean
    private function getIsAdmin($username)
    {
        $sql = "SELECT is_admin FROM admin WHERE username = :username";
        try
        {
            $statement = $this->pdo->prepare($sql);
            $statement->execute([':username' => $username]);
            $result = $statement->fetchAll(PDO::FETCH_CLASS);
            return $result;
        }
        catch(Exception $e)
        {
            die('Whoops, something went wrong' . $e->getMessage());
        }
    }

    public static function getIsAdminResult($username)
    {
        $result = App::get('auth')->getIsAdmin($username);
        return $result;
    }

    // returns admin key value
    private function getAdminValue($username)
    {
        $sql = "SELECT admin_key_value FROM admin WHERE username = :username";
        try
        {
            $statement = $this->pdo->prepare($sql);
            $statement->execute([':username' => $username]);
            $result = $statement->fetchAll(PDO::FETCH_CLASS);
            return $result;
        }
        catch(Exception $e)
        {
            die('Whoops, something went wrong' . $e->getMessage());
        }
    }

    public static function getAdminValueResult($username)
    {
        $result = App::get('auth')->getAdminValue($username);
        return $result;
    }

    // returns admin seesion time
    private function getAdminSessionTime($username)
    {
        $sql = "SELECT admin_session_time FROM admin WHERE username = :username";
        try
        {
            $statement = $this->pdo->prepare($sql);
            $statement->execute([':username' => $username]);
            $result = $statement->fetchAll(PDO::FETCH_CLASS);
            return $result;
        }
        catch(Exception $e)
        {
            die('Whoops, something went wrong' . $e->getMessage());
        }
    }

    public static function getAdminSessionTimeResult($username)
    {
        $result = App::get('auth')->getAdminSessionTime($username);
        return $result;
    }
}

?>