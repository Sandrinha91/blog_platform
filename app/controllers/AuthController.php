<?php

namespace App\Controllers;

use App\Models\Auth;
use App\Models\AdminValidation;
use App\Models\Blog;
use App\Models\AdminPost;
use App\Models\LogOut;
use App\Core\Request;
use App\Core\App;
use App\Core\Newsletter;
use JasonGrimes\Paginator;

class AuthController
{
    //function 
    public function returnView($value)
    {
        if( is_array($value) )
        {
            $username = $value[1];
        }
        elseif( is_string($value) )
        {
            $username = $value;
        }

        $result = Auth::getIsAdminResult($username);
        $is_admin = (int)$result[0]->is_admin;
        $resultTwo = Auth::getAdminValueResult($username);
        $admin_key = $resultTwo[0]->admin_key_value;
        $admin_seesion_time = Auth::getAdminSessionTimeResult($username);
        $admin_session_time = (int)$admin_seesion_time[0]->admin_session_time;
        $currentTime = time();
        $uri = Request::uri();

        if( $is_admin == 1 && $is_admin !== null && $admin_key !== null && password_verify($username, $admin_key) !== false )
        {
            if ( $currentTime <= $admin_session_time  && $admin_session_time != 0 )
            {
                if( strpos($uri, 'add') !== false )
                {
                    return view('newpost',
                    [
                        'username' => $username,
                    ]
                    );
                } 
                //admin view all posts from all categories 
                elseif( strpos($uri, 'en') !== false && strpos($uri, 'all') !== false)
                {
                    $lang = 'en';
                    $page = $value[3];

                    $totalItems = App::get('blog')->selectAllText($lang);
                    $itemsPerPage = 10;
                    $currentPage = $page;
                    $urlPattern = '/en/all/post/{' . $username . "}" . '/{(:num)}';

                    $paginator = new Paginator($totalItems, $itemsPerPage, $currentPage, $urlPattern);
                    $result = $paginator->updateArrayStart(1, 100 , 10);
                    $downLimit = $paginator->getStartValueByPage($page);
                    $upLimit = 10;

                    $numberOfPost = postNumber((int)$page, (int)$upLimit);

                    $posts = App::get('blog')->selectAllTextLimit($lang, $downLimit, $upLimit);

                    return view('table',
                    [
                        'posts' => $posts,
                        'username' => $username,
                        'lang' => $lang,
                        'paginator' => $paginator,
                        'numberOfPost' => $numberOfPost,
                    ]
                    );
                }
                elseif( strpos($uri, 'newsletter') !== false )
                {
                    $page = $value[3];

                    $totalItems = App::get('newsletter')->countEmails();
                    //die(var_dump($page));
                    $itemsPerPage = 5;
                    $currentPage = $page;
                    $urlPattern = '/read/all/newsletter/{' . $username .  '}/{(:num)}';

                    $paginator = new Paginator($totalItems, $itemsPerPage, $currentPage, $urlPattern);
                    $result = $paginator->updateArrayStart(1, 100 , 5);
                    $downLimit = $paginator->getStartValueByPage($page);
                    $upLimit = 5;
                    //die(var_dump($downLimit));
                    $numberOfPost = postNumber((int)$page, (int)$upLimit);

                    $emails = App::get('newsletter')->getEmailList($downLimit,$upLimit);

                    return view('newsletter',
                    [
                        'username' => $username,
                        'emails' => $emails,
                        'numberOfPost' => $numberOfPost,
                        'paginator' => $paginator,
                    ]
                    );
                }
                elseif( strpos($uri, 'delete') !== false )
                {
                    $id = $value[3];

                    App::get('newsletter')->deleteEmailById($id);
                    
                    return redirect('read/all/newsletter/{'.$username.'}/{1}');
                }
                elseif( strpos($uri, 'edit') !== false )
                {
                    $id = $value[3];
                    $lang = $value[5];
                    $post = App::get('post')->getSelectedText($lang,$id);
                    return view('editpost',
                    [
                        'username' => $username,
                        'post' => $post,
                    ]
                    );
                }

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

}

?>