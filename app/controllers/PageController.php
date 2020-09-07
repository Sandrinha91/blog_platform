<?php

namespace App\Controllers;

use App\Models\Language_model;

class PageController
{
    public function home($param)
    { 
        $lang = $param;
        
        return view('index',
            [
                'lang' => $lang,
                
            ]);
    }

    public function admin()
    {
        return view('login');
    }

    public function test()
    {
        $test = $_SERVER['HTTP_REFERER'];
        return view('test',
        [
            'test' => $test,
            
        ]
        ); 
    }

    public function notFound()
    {
        return view('pagenotfound'); 
    }

} 

?>