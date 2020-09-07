<?php

namespace App\Controllers;

use App\Core\Request;
use App\Core\App;
use App\Models\AdminPost;
use JasonGrimes\Paginator;

class BlogController
{

    //function blog- returns to blog.view all text and all categories
    public function blog($param)
    {
        $lang = $param[1];
        $page = $param[3];

        $totalItems = App::get('blog')->selectAllText($lang);
        $itemsPerPage = 5;
        $currentPage = $page;
        $urlPattern = '/blog/{' . $lang . "}" . '/{(:num)}';

        $paginator = new Paginator($totalItems, $itemsPerPage, $currentPage, $urlPattern);
        $result = $paginator->updateArrayStart(1, 100 , 5);
        $downLimit = $paginator->getStartValueByPage($page);
        $upLimit = 5;

        $posts = App::get('blog')->selectAllTextLimit($lang, $downLimit, $upLimit);
        $categories = App::get('blog')->selectAllCategories($lang);

        return view('blog',
        [
            'lang' => $lang,
            'posts' => $posts,
            'categories' => $categories,
            'paginator' => $paginator,
        ]
        );
    }

    //function blog- returns to blog.view text from selected category
    public function fromCategory($param)
    {
        $lang = $param[1];
        $id = $param[3];
        $page = $param[5];

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

        return view('category',
        [
            'lang' => $lang,
            'posts' => $posts,
            'categories' => $categories,
            'id' => $id,
            'paginator' => $paginator,
        ]
        );
    }

    // function for read single text and pull related text
    public function readText($param)
    {
        $lang = $param[1];
        $id = $param[3];

        $table = 'post_' . $lang;
        $category = 'category_' . $lang;

        $posts = App::get('blog')->selectText($table, $id);
        $categories = App::get('blog')->selectAllCategories($category);

        $categoryId = AdminPost::returnCategoryByPostId($id, $table);
        $arrayObjId = App::get('blog')->selectAllPostID($table,$id,$categoryId);
        $arrayId = array();
        $numbers = $arrayObjId ;
        shuffle($numbers);

        foreach ($numbers as $number) 
        {
            $arrayId[] = (int)$number;  
        }

        if( count($arrayId) == 1)
        {
            $r_id= $arrayId[0];
            $related_posts = array(App::get('blog')->selectRelatedText($table,$r_id));
        }
        elseif( count($arrayId) == 2)
        {
            $r_id= $arrayId[0];
            $r_id1= $arrayId[1];
            $related_post = App::get('blog')->selectRelatedText($table,$r_id);
            $related_post1 = App::get('blog')->selectRelatedText($table,$r_id1);
            $related_posts = array($related_post, $related_post1);
        }
        elseif( count($arrayId) >= 3 )
        {
            $r_id= $arrayId[0];
            $r_id1= $arrayId[1];
            $r_id2= $arrayId[2];

            $related_post = App::get('blog')->selectRelatedText($table,$r_id);
            $related_post1 = App::get('blog')->selectRelatedText($table,$r_id1);
            $related_post2 = App::get('blog')->selectRelatedText($table,$r_id2);
            $related_posts = array($related_post, $related_post1, $related_post2);
        }
        elseif( count($arrayId) == 0 )
        {
            $arrayObjId = App::get('blog')->selectAllPostIDForAny($table,$id,$categoryId);
            $arrayId = array();
            $numbers = $arrayObjId ;
            shuffle($numbers);
            foreach ($numbers as $number) 
            {
                $arrayId[] = (int)$number;  
            }

            $r_id= $arrayId[0];
            $r_id1= $arrayId[1];
            $r_id2= $arrayId[2];

            $related_post = App::get('blog')->selectRelatedText($table,$r_id);
            $related_post1 = App::get('blog')->selectRelatedText($table,$r_id1);
            $related_post2 = App::get('blog')->selectRelatedText($table,$r_id2);
            $related_posts = array($related_post, $related_post1, $related_post2);
        }

        return view('text',
        [
            'id' => $id,
            'lang' => $lang,
            'posts' => $posts,
            'categories' => $categories,
            'related_posts' => $related_posts,
        ]
        );
        
    }
}

?>