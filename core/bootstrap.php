<?php

use App\Core\App;
use App\Core\Create_database;
use App\Core\Database\Connection;
use App\Core\Database\QueryBuilder;
use App\Models\Blog;
use App\Models\AdminValidation;
use App\Models\Auth;
use App\Models\AdminPost;
use App\Models\Search;
use App\Models\LogOut;
use App\Models\Newsletter;
use App\Models\AddText;
use App\Models\ForgotPassword;
use App\Models\UserContactValidation;
use App\Models\Verification;

App::bind('config', require 'config.php');
//bind f-ja uzima fajl config.php i stavlja ga u kutiju koja ima nalepnicu 'config' 

//die(var_dump(App::get('config')));



//ovo pravi konekciju i u klasu query builder na polje $pdo 
//conection::make vraca 'mytodo', 'root' , 'sifra'...
//die(var_dump(   App::get('config')['database']    ));


//$db = Connection::make(App::get('config')['database']);
//Create_database::create_database($db);

// if ( Create_database::$created !== true )
// {
//     $db = Connection::make(App::get('config')['database']);
//     Create_database::create_database($db);
//     echo "napravilo je bazu";
// }
// else
// {
//     echo "preskocilo je blok";
//     Create_database::isCreated(false);
// }


// dependency injection -  conection in all models
App::bind('blog', new Blog(Connection::make(App::get('config')['database'])));
App::bind('admin', new AdminValidation(Connection::make(App::get('config')['database'])));
App::bind('auth', new Auth(Connection::make(App::get('config')['database'])));
App::bind('post', new AdminPost(Connection::make(App::get('config')['database'])));
App::bind('search', new Search(Connection::make(App::get('config')['database'])));
App::bind('logout', new LogOut(Connection::make(App::get('config')['database'])));
App::bind('newsletter', new Newsletter(Connection::make(App::get('config')['database'])));
App::bind('addtext', new AddText(Connection::make(App::get('config')['database'])));
App::bind('forgot', new ForgotPassword(Connection::make(App::get('config')['database'])));
App::bind('user', new UserContactValidation(Connection::make(App::get('config')['database'])));
App::bind('verification', new Verification(Connection::make(App::get('config')['database'])));

//die(var_dump(App::get('database')));
//onda App::get('database') postaje 
//object(QueryBuilder)[3]
  //protected 'pdo' => 
  //object(PDO)[2]



// function for returning wrighte view
function view($name, $data=[])
{
    extract($data);
    return require "app/views/{$name}.view.php";
}

function redirect($path)
{
    header("Location:/{$path}");
}

function postNumber($page, $increasedFor)
{
    return $number = (($page - 1) * $increasedFor) + 1;
}