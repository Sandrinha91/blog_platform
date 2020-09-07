<?php

namespace App\Controllers;

use App\Models\Blog;
use App\Models\Search;
use App\Core\Request;
use App\Core\App;
use JasonGrimes\Paginator;
use App\Models\Auth;

class SearchController
{

    private $keyWord = null;

    //check data - login submit
    public function checkData($value)
    {
        $search = htmlspecialchars($_POST['search']);
        $lang = $_POST['language'];
        $result = App::get('search')->validateSearch($search);
        $errors = App::get('search')->getSearchError();
        $url = Request::uri();

        //basic validation is ok
        if( count($errors) == 0 )
        {
            $this->keyWord = $search;
            $savedKey = $this->keyWord;
            //proceed to  check data with db, returns true or false 
                
            if( strpos($url, 'AngelOzzyVuk90') !== false )
            {
                $username = $value[1];
                $page = $value[3];
                //die(var_dump($value));

                $totalItems = App::get('search')->countPosts($lang, $search);
                $itemsPerPage = 10;
                $currentPage = $page;
                $urlPattern = '/check/text/{' . $username . "}/{"  . $lang .  "}/{" .  $savedKey  . '}/{(:num)}';
        
                $paginator = new Paginator($totalItems, $itemsPerPage, $currentPage, $urlPattern);
                $result = $paginator->updateArrayStart(1, 100 , 10);
                $downLimit = $paginator->getStartValueByPage($page);
                $upLimit = 10;

                $numberOfPost = postNumber((int)$page, (int)$upLimit);

                $posts = App::get('search')->returnSearchPosts($lang, $search ,$downLimit, $upLimit);

                return view('table',
                [
                    'posts' => $posts,
                    'username' => $username,
                    'lang' => $lang,
                    'paginator' => $paginator,
                    'search' => $search,
                    'numberOfPost' => $numberOfPost,
                ]
                );
            }
            // search for user for category view
            elseif( strpos($url, 'user/search/post') !== false && strpos($url, 'sr') !== false || strpos($url, 'user/search/post') !== false && strpos($url, 'en') !== false)
            {
                $lang = $value[1];
                $c_id = $value[3];
                $page = $value[5];

                $totalItems = App::get('search')->countPostsByCategory($lang, $search, $c_id);
                $itemsPerPage = 5;
                $currentPage = $page;
                $urlPattern = '/public/search/post/categories/{' . $lang . "}/{" .  $c_id .  "}/{" .  $savedKey  .  '}/{(:num)}';
        
                $paginator = new Paginator($totalItems, $itemsPerPage, $currentPage, $urlPattern);
                $result = $paginator->updateArrayStart(1, 100 , 5);
                $downLimit = $paginator->getStartValueByPage($page);
                $upLimit = 5;

                $categories = App::get('blog')->selectAllCategories($lang);
                $posts = App::get('search')->returnPostsFromCategoryId($lang, $search, $c_id, $downLimit, $upLimit );
                $id = $c_id;

                return view('category',
                    [
                        'posts' => $posts,
                        'lang' => $lang,
                        'categories' => $categories,
                        'id' => $id,
                        'paginator' => $paginator,
                        'search' => $search,
                    ]
                    );
            }
            // search for user for all posts view
            elseif( strpos($url, 'sr') !== false || strpos($url, 'en') !== false )
            {
                $lang = $value[1];
                $page = $value[3];

                $totalItems = App::get('search')->countPosts($lang, $search);
                $itemsPerPage = 5;
                $currentPage = $page;
                $urlPattern = '/search/view/user/check/{' . $lang . "}/{" .  $savedKey  . '}/{(:num)}';
        
                $paginator = new Paginator($totalItems, $itemsPerPage, $currentPage, $urlPattern);
                $result = $paginator->updateArrayStart(1, 100 , 5);
                $downLimit = $paginator->getStartValueByPage($page);
                $upLimit = 5;

                $categories = App::get('blog')->selectAllCategories($lang);
                $posts = App::get('search')->returnSearchPosts($lang, $search ,$downLimit, $upLimit);

                return view('blog',
                    [
                        'posts' => $posts,
                        'lang' => $lang,
                        'categories' => $categories,
                        'paginator' => $paginator,
                        'search' => $search,
                    ]
                    );
            }
        }
        // if there is an ERRORS
        elseif( strpos($url, 'AngelOzzyVuk90') !== false )
        {
            $username = $value[1];
            $page = $value[3];

            $totalItems = App::get('search')->countPosts($lang, $search);
            $itemsPerPage = 10;
            $currentPage = $page;
            $urlPattern = '/en/all/post/{' . $username . '}/{(:num)}';
        
            $paginator = new Paginator($totalItems, $itemsPerPage, $currentPage, $urlPattern);
            $result = $paginator->updateArrayStart(1, 100 , 10);
            $downLimit = $paginator->getStartValueByPage($page);
            $upLimit = 10;

            $posts = App::get('blog')->selectAllTextLimit($lang, $downLimit, $upLimit);
            
            $errorMsg = '<div class="col-12 alert alert-warning" role="alert"><span>You must insert a key word in order to search!</span></div>';

            return view('table',
            [
                'posts' => $posts,
                'username' => $username,
                'lang' => $lang,
                'errorMsg' => $errorMsg,
                'paginator' => $paginator,
            ]
            );
        }
        //if there is an ERROR and it needs to be returned to blog page and posts from all category view
        elseif( strpos($url, 'search/view/user/check') !== false &&  strpos($url, 'sr') !== false || strpos($url, 'search/view/user/check') !== false && strpos($url, 'en') !== false )
        {
            $lang = $value[1];
            $page = $value[3];

            $totalItems = App::get('blog')->selectAllText($lang);
            $itemsPerPage = 5;
            $currentPage = $page;
            $urlPattern = '/blog/{' . $lang . "}" . '/{(:num)}';

            $paginator = new Paginator($totalItems, $itemsPerPage, $currentPage, $urlPattern);
            $result = $paginator->updateArrayStart(1, 100 , 5);
            $downLimit = $paginator->getStartValueByPage($page);
            $upLimit = 5;

            $categories = App::get('blog')->selectAllCategories($lang);
            $posts = App::get('blog')->selectAllTextLimit($lang, $downLimit, $upLimit);

            if( strpos($url, 'sr') !== false  )
            {
                $errorMsg = '<div class="col-12 alert alert-warning" role="alert">Unesite vrednost kako bi izvršili pretragu!</div>';
            }
            elseif( strpos($url, 'en') !== false )
            {
                $errorMsg = '<div class="col-12 alert alert-warning" role="alert">You must insert a key word in order to search!</div>';
            }
            
            return view('blog',
                [
                    'posts' => $posts,
                    'lang' => $lang,
                    'categories' => $categories,
                    'errorMsg' => $errorMsg,
                    'paginator' => $paginator,
                ]
                );
        }
        //if there is an ERROR and it needs to be returned to blog page and posts from SELECTED category view
        elseif( strpos($url, 'user/search/post/category') !== false &&  strpos($url, 'en') !== false ||  strpos($url, 'user/search/post/category') !== false &&  strpos($url, 'sr') !== false)
        {
            $lang = $value[1];
            $id = $value[3];
            $page = $value[5];

            $totalItems = App::get('blog')->countFromCategory($lang, $id);
            $itemsPerPage = 5;
            $currentPage = $page;
            $urlPattern = '/category/{' . $lang . '}/{' . $id . '}/{(:num)}';

            $paginator = new Paginator($totalItems, $itemsPerPage, $currentPage, $urlPattern);
            $result = $paginator->updateArrayStart(1, 100 , 5);
            $downLimit = $paginator->getStartValueByPage($page);
            $upLimit = 5;

            $posts = App::get('blog')->selectPostsFromCategory($lang, $id, $downLimit, $upLimit);
            $categories = App::get('blog')->selectAllCategories($lang);

            if( strpos($url, 'sr') !== false  )
            {
                $errorMsg = '<div class="col-12 alert alert-warning" role="alert">Unesite vrednost kako bi izvršili pretragu!</div>';
            }
            elseif( strpos($url, 'en') !== false )
            {
                $errorMsg = '<div class="col-12 alert alert-warning" role="alert">You must insert a key word in order to search!</div>';
            }
            
            return view('category',
                [
                    'posts' => $posts,
                    'lang' => $lang,
                    'categories' => $categories,
                    'errorMsg' => $errorMsg,
                    'id' => $id,
                    'paginator' => $paginator,
                ]
                );
        }
    } 
    
    public function showPosts($value)
    {
        $url = Request::uri();

        if( strpos($url, 'AngelOzzyVuk90') !== false )
        {
            $username = $value[1];

            $result = Auth::getIsAdminResult($username);
            $is_admin = (int)$result[0]->is_admin;
            $resultTwo = Auth::getAdminValueResult($username);
            $admin_key = $resultTwo[0]->admin_key_value;
            $admin_seesion_time = Auth::getAdminSessionTimeResult($username);
            $admin_session_time = (int)$admin_seesion_time[0]->admin_session_time;
            $currentTime = time();

            if( $is_admin == 1 && $is_admin !== null && $admin_key !== null && password_verify($username, $admin_key) !== false )
            {
                if ( $currentTime <= $admin_session_time  && $admin_session_time != 0 )
                {
                    $username = $value[1];
                    $lang = $value[3];
                    $search = $value[5];
                    $page = $value[7];
        
                    $totalItems = App::get('search')->countPosts($lang, $search);
                    $itemsPerPage = 10;
                    $currentPage = $page;
                    $urlPattern = '/check/text/{' . $username . "}/{"  . $lang .  "}/{" .  $search  . '}/{(:num)}';
                
                    $paginator = new Paginator($totalItems, $itemsPerPage, $currentPage, $urlPattern);
                    $result = $paginator->updateArrayStart(1, 100 , 10);
                    $downLimit = $paginator->getStartValueByPage($page);
                    $upLimit = 10;
        
                    $posts = App::get('search')->returnSearchPosts($lang, $search ,$downLimit, $upLimit);
                    $numberOfPost = postNumber((int)$page, (int)$upLimit);
        
                    return view('table',
                    [
                        'posts' => $posts,
                        'username' => $username,
                        'lang' => $lang,
                        'paginator' => $paginator,
                        'search' => $search,
                        'numberOfPost' => $numberOfPost,
                    ]
                    );
                }
                else
                {
                    App::get('logout')->setAdminProperties($username, '0', null, '0');

                    return redirect('homepage/login/admin');
                }
            }
            else
            {
                return redirect('page/not/found');
            }
        }
        // search for user for category view
        elseif( strpos($url, 'public/search/post') !== false && strpos($url, 'sr') !== false || strpos($url, 'user/search/post') !== false && strpos($url, 'en') !== false)
        {
            $lang = $value[1];
            $c_id = $value[3];
            $search = $value[5];
            $page = $value[7];

            $totalItems = App::get('search')->countPostsByCategory($lang, $search, $c_id);
            $itemsPerPage = 5;
            $currentPage = $page;
            $urlPattern = '/public/search/post/categories/{' . $lang . "}/{" .  $c_id .  "}/{" .  $search  .  '}/{(:num)}';
    
            $paginator = new Paginator($totalItems, $itemsPerPage, $currentPage, $urlPattern);
            $result = $paginator->updateArrayStart(1, 100 , 5);
            $downLimit = $paginator->getStartValueByPage($page);
            $upLimit = 5;

            $categories = App::get('blog')->selectAllCategories($lang);
            $posts = App::get('search')->returnPostsFromCategoryId($lang, $search, $c_id, $downLimit, $upLimit );
            $id = $c_id;

            return view('category',
                [
                    'posts' => $posts,
                    'lang' => $lang,
                    'categories' => $categories,
                    'id' => $id,
                    'paginator' => $paginator,
                    'search' => $search,
                ]
                );
        }
        elseif( strpos($url, 'sr') !== false || strpos($url, 'en') !== false )
        {
            $lang = $value[1];
            $savedKey = $value[3];
            $page = $value[5];

            $totalItems = App::get('search')->countPosts($lang, $savedKey);
            $itemsPerPage = 5;
            $currentPage = $page;
            $urlPattern = '/search/view/user/check/{' . $lang . "}/{" .  $savedKey  . '}/{(:num)}';

            $paginator = new Paginator($totalItems, $itemsPerPage, $currentPage, $urlPattern);
            $result = $paginator->updateArrayStart(1, 100 , 5);
            $downLimit = $paginator->getStartValueByPage($page);
            $upLimit = 5;

            $categories = App::get('blog')->selectAllCategories($lang);
            $posts = App::get('search')->returnSearchPosts($lang, $savedKey ,$downLimit, $upLimit);
            $search = $savedKey;

            return view('blog',
                [
                    'posts' => $posts,
                    'lang' => $lang,
                    'categories' => $categories,
                    'paginator' => $paginator,
                    'search' => $search,
                ]
                );
        }
    }


}

?>