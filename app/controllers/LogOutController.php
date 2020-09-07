<?php

namespace App\Controllers;

use App\Models\Auth;
use App\Core\Request;
use App\Core\App;

class LogOutController
{
    //function 
    public function Logout($value)
    {
        $username = $value;
        $result = Auth::getIsAdminResult($username);
        $result = (int)$result[0]->is_admin;
        $resultTwo = Auth::getAdminValueResult($username);
        $resultTwo = $resultTwo[0]->admin_key_value;

        if( $result == 1 && $result !== null && $resultTwo !== null && password_verify($username, $resultTwo) !== false)
        {
            App::get('logout')->setAdminProperties($username, '0', null, '0');
            return redirect('homepage/login/admin');
        }
        
    }

}

?>