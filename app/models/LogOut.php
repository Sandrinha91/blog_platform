<?php

namespace App\Models;

use App\Core\Database\Connection;
use PDO;
use App\Core\App;

class LogOut
{
    protected $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function setAdminProperties($username, $is_admin, $key_value, $time)
    {
        $sql = "UPDATE admin 
                SET is_admin = :is_admin, admin_key_value = :admin_key_value, admin_session_time = :admin_session_time
                WHERE username = :username";
        
        try
        {
            $statement = $this->pdo->prepare($sql);
            $statement->execute([':is_admin' => $is_admin, ':admin_key_value' => $key_value ,':username' => $username, ':admin_session_time' => $time ]);
        }
        catch(Exception $e)
        {
            die('Whoops, something went wrong' . $e->getMessage());
        }
    }

}

?>