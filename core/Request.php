<?php

namespace App\Core;

class Request
{
    public static function uri()
    {
        return trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        //ovo vraca url ali umesto npr names/name=Jane
        //vraca samo names
        //$a = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        //$a = $_SERVER['REQUEST_URI'];
        //die(var_dump($a));

    }

    public static function method()
    {
        return $_SERVER['REQUEST_METHOD'];

        //ovo vraca get ili post
    }
}