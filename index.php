<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <!-- <link rel="stylesheet" type="text/css" href="../public/css/bootstrap.css"> -->
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- <link rel="stylesheet" type="text/css" href="https://saska.localhost/public/css/style.css">  -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css">
    <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/v4-shims.css"> -->
    <link rel="stylesheet" type = "text/css" href="/public/css/main.css"> 
    <title>Document</title>

    <script type="text/javascript">
    
        function ConfirmDelete(post_id, username, lan)
        {
            if (confirm('Do you want to Delete' +post_id+ '?'))
                        
                location.href=`/erase/text/%7B${post_id}%7D/%7B${username}%7D/%7B${lan}%7D`;                        
                            
        }
              
    </script>
    
</head>
<body>
    
    <?php
        require 'vendor/autoload.php';
        require 'core/bootstrap.php';

        use\App\Core\{Router, Request};
        use\App\Controllers\{LanguageController};
        use\App\Models\{Language};

        LanguageController::getCurentLanguage(Request::uri());
        //var_dump(Request::uri());
        //Language_model::load('app/languages.php');
        Language::sessionStart();

        $words = LanguageController::getCurentLanguageArray();
        $_SESSION['wordsArray'] = $words;

        //var_dump($_SESSION['wordsArray']);

        Router::load('app/routes.php')
            ->direct(Request::uri(), Request::method());

            //$test = Router::load('app/routes.php');
        //die(var_dump($test));
        //ovde dobijamo 
        // object(App\Core\Router)[4]
        //   public 'routes' => 
        //     array (size=2)
        //       'GET' => 
        //         array (size=4)
        //           '' => string 'PagesController@home' (length=20)
        //           'about' => string 'PagesController@about' (length=21)
        //           'contact' => string 'PagesController@contact' (length=23)
        //           'users' => string 'UsersController@index' (length=21)
        //       'POST' => 
        //         array (size=1)
        //           'users' => string 'UsersController@store' (length=21)

            // load('app/routes.php') - ucitava fajl u fajlu se poziva $routes->get() f-ja 

            //2.korak direct f-ja  , ocekuje dve varijable , prva je url a druga vrsta urla get ili post
            //ona ispituje da li u polju(nizu) $routes iz klase router postoji prosledjeni url sa prosledjenom metodom


            //Request::uri() - uzima trenutnu url adresu

            //Request::method() - ispituje koja je metoda get ili post 

            // 3.korak - 
    ?>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>
