<?php

namespace App\Controllers;

use App\Core\Request;
use App\Models\Language;


class LanguageController
{

    public static function getCurentLanguage($uri)
    {
        $key = 'sr';
        
        if( strpos($uri, $key) !== false || $uri == '' )
        {
            return $_SESSION["lang"]='sr';
        }
        else
        {
            return $_SESSION["lang"]='en';
        }
        
    }

    public static function getCurentLanguageArray()
    {
        $wordsArray = Language::load('app/languages.php');
        //die(var_dump($wordsArray));
        $words = [];
        //var_dump(Language::getCurentLanguage(Request::uri()));
        if( LanguageController::getCurentLanguage(Request::uri()) == 'en' )
        {
            return $wordsArray->getEnWords();
        }
        else
        {
            return $wordsArray->getSrWords();
        }
    }

}

?>