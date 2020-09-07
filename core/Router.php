<?php

namespace App\Core;
//namespace App\Exceptions;


class Router
{
    public $routes = [
        'GET' => [],
        'POST' => []
    ];

    public static function load($file)
    {
        $router = new static;
        //die(var_dump($router));
        //$router je niz 'GET' => 
    //     array (size=0)
    //     empty
    // 'POST' => 
    //   array (size=0)
    //     empty
        require $file;

        //die(var_dump($file));

        return $router;
    }

    public function get($uri,$contorlller)
    {
        //nizu routes-GET se dodaje novi kljuc $uri i njegova vrednost $controller
        $this->routes['GET'][$uri] = $contorlller;
    }

    public function post($uri,$contorlller)
    {
        //nizu routes-POST se dodaje novi kljuc $uri i njegova vrednost $controller
        $this->routes['POST'][$uri] = $contorlller;
    }

    // public function define($routes)
    // {
    //     $this->routes = $routes;
    // }

    public function direct($uri,$requestType)
    {
        $routesArray = $this->routes[$requestType];
        $uriParser = explode('/', $uri);
        $valueValue = null;
        //echo $_SESSION['lang'];
        //die(var_dump($routesArray));
        //var_dump($uriParser);
        //die(var_dump($uriParser));

        //definisanje $valuePass
        foreach ( $routesArray as $key => $value )
        {
            
            //var_dump($uriParser);
            //die(var_dump($uriParser));
             if( preg_match( "/\b$uriParser[0]\b/i", $key, $match) )
            {
                //die(var_dump($key));
                //die(var_dump(preg_match( "/\b$uriParser[0]\b/i", $key, $match)));
                if( count($uriParser) > 1 )
                {
                    //die(var_dump(count($uriParser)>=1));
                    if( in_array ( '%7B', $uriParser, FALSE ) )
                    {
                        $valueValue = null;
                    }
                    else
                    {
                        $counter = 0;
                        $position = [];
                        $valuePass = [];

                        foreach( $uriParser as $key_one => $value_one )
                        {
                            //die(var_dump($value_one));
                            //die(var_dump($uriParser));
                            if( strpos( $value_one, '%7B') !== false )
                            {
                                //var_dump($value_one);
                                $counter += 1;
                                array_push($valuePass, $value_one);
                            }
                        }
                        //die(var_dump($valuePass));
                        //var_dump($counter);
                        if( $counter > 0 && $counter < 2 )
                        {
                            $urlPartials = explode('/', $key);
                            $valueCode = $urlPartials[1];
                            $valueDefault = $valuePass[0];
                            $parameter = substr($valueDefault,3);
                            //$valueValue = chop($parameter, "%7D");
                            $valueValue = substr($parameter, 0, strpos($parameter, "%7D"));

                            //var_dump($key);
                            //var_dump($valueValue);
                            //var_dump($this->routes[$requestType]);
                            //die(var_dump($uri));
                            if (array_key_exists($key, $this->routes[$requestType])) {
                                $controlerParser = explode('@', $this->routes[$requestType][$key]);
                                //die(var_dump($controlerParser));
                                $controller = $controlerParser[0];
                                $action = $controlerParser[1];
                                //die(var_dump($action));
                                return $this->callAction($controlerParser[0], $controlerParser[1], $valueValue);  
                            }
                        }
                        elseif($counter >= 2)
                        {
                            $valueArray = [];
                            
                            $valuePatrtials = explode('/', $uri);
                            //die(var_dump($valuePatrtials));

                            foreach( $valuePatrtials as $keyValue => $keyVal)
                            {
                                
                                if( strpos($keyVal, '%7B') !== false )
                                {   //
                                    $parameter = substr($keyVal,3);
                                    //$valueValue = chop($parameter, " %7D");
                                    $valueValue = substr($parameter, 0, strpos($parameter, "%7D"));
                                    //var_dump($valueValue);
                                    array_push($valueArray,'/');
                                    array_push($valueArray,$valueValue);
                                    //var_dump($valueArray);

                                }
                            }
                            //die(var_dump($valueArray));
                            if (array_key_exists($key, $this->routes[$requestType])) {
                                $controlerParser = explode('@', $this->routes[$requestType][$key]);
                                //die(var_dump($controlerParser));
                                $controller = $controlerParser[0];
                                $action = $controlerParser[1];
                                //die(var_dump($action));
                                return $this->callAction($controlerParser[0], $controlerParser[1], $valueArray);  
                            }
                            //var_dump($valueArray);
                        }
                    }
                }
            }
        }
        //var_dump($valueValue);
        if (array_key_exists($uri, $this->routes[$requestType])) {
            //die($this->routes[$requestType][$uri]);
            //die(var_dump($uri));
            //ovo je sad UsersController@index

            $controlerParser = explode('@', $this->routes[$requestType][$uri]);
            //die(var_dump($controlerParser));
            $controller = $controlerParser[0];
            
			$action = $controlerParser[1];
            //die(var_dump($valueValue));
            return $this->callAction($controlerParser[0], $controlerParser[1], $valueValue);
            
            //$a = $this->callAction($controlerParser[0], $controlerParser[1], $parameter);
            // die(var_dump($parameter));
		}
    }

    protected function callAction($controller, $action, $parameter)
    {
        $controller = "App\\Controllers\\{$controller}" ;
        //die(var_dump($controller));
        // var_dump($action);
        // var_dump($parameter);
        $controller = new $controller;
        
        //die(var_dump($controller));
        //die(var_dump($action));

        //die(var_dump($controller, $action));
        if( !method_exists($controller, $action) )
        {
            throw new Exception(
                "{$controller} does not respond to the {$action} action."
            );
            
        }
        return $controller->$action($parameter);
    }
}