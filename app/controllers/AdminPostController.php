<?php

namespace App\Controllers;

use App\Models\AdminPost;
use App\Core\Request;
use App\Core\App;
use App\Models\Auth;
use JasonGrimes\Paginator;

class AdminPostController
{
    //search function function - 0(for all categories) post method
    public function postFilter($value)
    {
        $lang = $_POST['language'];
        $category = $_POST['category'];
        $id = (int)$category;
        $username = $value[1];
        $page = $value[3];
        
        $itemsPerPage = 10;
        $currentPage = $page;
        $urlPattern = '/from/filter/{' . $username . '}/{' . $lang . "}" . '/{' . $id  . '}/{(:num)}';
        
        if( $category == 0 )
        {
            $totalItems = App::get('blog')->selectAllText($lang);
        }
        else
        {
            $totalItems = App::get('blog')->countFromCategory($lang,$id);
        }

        $paginator = new Paginator($totalItems, $itemsPerPage, $currentPage, $urlPattern);
        $result = $paginator->updateArrayStart(1, 100 , 10);
        $downLimit = $paginator->getStartValueByPage($page);
        $upLimit = 10;

        $numberOfPost = postNumber((int)$page, (int)$upLimit);

        if( $category == 0 )
        {
            $posts = App::get('blog')->selectAllTextLimit($lang,$downLimit, $upLimit);
        }
        else
        {
            $posts = App::get('blog')->selectPostsFromCategory($lang,$id,$downLimit,$upLimit);
        }

        return view('table',
            [
                'username' =>$username,
                'lang' => $lang,
                'category' => $category,
                'posts' => $posts,
                'paginator' => $paginator,
                'numberOfPost' => $numberOfPost,
            ]
            );
    }

    //search function function - 0(for all categories) GET method
    public function getPostFilter($value)
    {
        //die(var_dump($value));
        $username = $value[1];
        $lang = $value[3];
        $id = $value[5];
        $page = $value[7];

        $itemsPerPage = 10;
        $currentPage = $page;
        $urlPattern = '/from/filter/{' . $username . '}/{' . $lang . "}" . '/{' . $id  . '}/{(:num)}';
        
        if( $id == 0 )
        {
            $totalItems = App::get('blog')->selectAllText($lang);
        }
        else
        {
            $totalItems = App::get('blog')->countFromCategory($lang,$id);
        }

        $paginator = new Paginator($totalItems, $itemsPerPage, $currentPage, $urlPattern);
        $result = $paginator->updateArrayStart(1, 100 , 10);
        $downLimit = $paginator->getStartValueByPage($page);
        $upLimit = 10;
        
        $numberOfPost = postNumber((int)$page, (int)$upLimit);

        if( $id == 0 )
        {
            $posts = App::get('blog')->selectAllTextLimit($lang,$downLimit, $upLimit);
        }
        else
        {
            $posts = App::get('blog')->selectPostsFromCategory($lang,$id,$downLimit,$upLimit);
        }

        return view('table',
            [
                'username' =>$username,
                'lang' => $lang,
                'posts' => $posts,
                'paginator' => $paginator,
                'numberOfPost' => $numberOfPost,
            ]
            );
    }

    // delete post
    public function deletePost($param)
    {
        $a = $param;
        $id= $param[1];
        $username = $param[3];
        $lang = $param[5];

        // admin authorization
        $result = Auth::getIsAdminResult($username);
        $is_admin = (int)$result[0]->is_admin;

        $resultTwo = Auth::getAdminValueResult($username);
        $admin_key = $resultTwo[0]->admin_key_value;
        $admin_seesion_time = Auth::getAdminSessionTimeResult($username);
        $admin_session_time = (int)$admin_seesion_time[0]->admin_session_time;
        $currentTime = time();

        if( $is_admin == 1 && $is_admin !== null && $admin_key !== null && password_verify($username, $admin_key) !== false)
        {
            // authorization pass 
            //check for session time
            if ( $currentTime <= $admin_session_time  && $admin_session_time != 0 )
            {
                //session time valid
                //deleted post
                $id = (int)$id;
                $table = 'post_' . $lang;
                //die(var_dump($id));
                $category_id = AdminPost::returnCategoryByPostId($id, $table);
                $delete = AdminPost::getDeletePost($id, $lang);
                //die(var_dump($category_id));

                $totalItems = App::get('blog')->countFromCategory($lang, $id);
                $itemsPerPage = 10;
                $page = 1;
                $urlPattern = '/from/filter/{' . $username . '}/{' . $lang . "}" . '/{' . $category_id  . '}/{(:num)}';

                $paginator = new Paginator($totalItems, $itemsPerPage, $page, $urlPattern);
                $result = $paginator->updateArrayStart(1, 100 , 10);
                $downLimit = $paginator->getStartValueByPage($page);
                $upLimit = 10;

                //$posts = App::get('blog')->selectPostsFromCategory($lang, $id, $downLimit, $upLimit);
                $posts = AdminPost::getPostByCategory( $table, $category_id, $downLimit, $upLimit);
                //die(var_dump($posts));
                
                return redirect('from/filter/%7BAngelOzzyVuk90%7D/%7Ben%7D/%7B' . $category_id . '%7D/%7B1%7D');

            }
            else
            {
                //session time not valid
                App::get('admin')->setIsAdmin( 0, $username, 0 );
                App::get('admin')->setKey(0, $username);

                return redirect('homepage/login/admin');
            }
        }
    }


}

?>