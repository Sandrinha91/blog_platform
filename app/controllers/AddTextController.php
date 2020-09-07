<?php

namespace App\Controllers;

use App\Models\Auth;
use App\Core\Request;
use App\Core\App;
use App\Core\Newsletter;

class AddTextController
{
    //validate new text and add if ok
    public function addNewText($value)
    {
        if( is_array($value) )
        {
            $username = $value[3];
            $id = $value[1];
        }
        elseif( is_string($value) )
        {
            $username = $value;
        }
        
        $lang = htmlspecialchars($_POST['language']);
        $category = htmlspecialchars($_POST['category']);
        $author = htmlspecialchars($_POST['author']);
        $heading = htmlspecialchars($_POST['heading']);
        $review = htmlspecialchars($_POST['review']);
        $file = $_FILES['image_widget'];
        $text_content = htmlspecialchars($_POST['post']);

        $arrayValues = array($lang, $category, $author, $heading, $review , $text_content);
        foreach( $arrayValues as $value )
        {
            App::get('addtext')->validateField($value);
        }

        App::get('addtext')->validateImage($file);
        $errors = App::get('addtext')->getError();

        //validation is ok
        if( count($errors) == 0 )
        {
            $picture_path = App::get('addtext')->storeImg($file);
            $time = time();
            App::get('addtext')->storePost($username, $lang, $heading, $review, $text_content, $picture_path, $author, $category, $time);

            //post added redirect with msg success
            return redirect('new/post/added/{AngelOzzyVuk90}');
        }
        else
        {
            $errorImgFormat = '<div class="col-12 alert alert-warning" role="alert">' . $errors['format'] . '</div>';
            $errorImg = '<div class="col-12 alert alert-warning" role="alert">' . $errors['image'] . '</div>';
            $errorField = '<div class="col-12 alert alert-warning" role="alert">' . $errors['field'] . '</div>';

            return view('newpost',
                [
                    'username' => $username,
                    'errorImgFormat' => $errorImgFormat,
                    'errorImg' => $errorImg,
                    'errorField' => $errorField,
                ]
                );
        }   
    }

    //edit text
    public function editText($value)
    {
        //die(var_dump($value));
        if( is_array($value) )
        {
            $username = $value[1];
            $id = $value[3];
        }
        elseif( is_string($value) )
        {
            $username = $value;
        }
        
        $lang = htmlspecialchars($_POST['language']);
        $category = htmlspecialchars($_POST['category']);
        $author = htmlspecialchars($_POST['author']);
        $heading = htmlspecialchars($_POST['heading']);
        $review = htmlspecialchars($_POST['review']);
        $file = $_FILES['image_widget'];
        $text_content = htmlspecialchars($_POST['post']);

        $arrayValues = array($lang, $category, $author, $heading,$review, $text_content);
        //die(var_dump($arrayValues));
        foreach( $arrayValues as $value )
        {
            App::get('addtext')->validateField($value);
        }

        App::get('addtext')->validateImage($file);
        $errors = App::get('addtext')->getError();

        //validation is ok
        if( count($errors) == 0 )
        {
            $id = (int)$id;
            $picture_path = App::get('addtext')->storeImg($file);
            $date = time();
            App::get('addtext')->updatePost($username, $lang, $heading, $text_content, $review , $picture_path, $author, $category, $id, $date);
            $post = App::get('post')->getSelectedText($lang,$id);
            
            return redirect('finished/edit/post/{AngelOzzyVuk90}/{'.(int)$post[0]->id.'}/{'.$lang.'}');

        }
        else
        {
            $post = App::get('post')->getSelectedText($lang,$id);
            $errorImgFormat = '<div class="col-12 alert alert-warning" role="alert">' . $errors['format'] . '</div>';
            $errorImg = '<div class="col-12 alert alert-warning" role="alert">' . $errors['image'] . '</div>';
            $errorField = '<div class="col-12 alert alert-warning" role="alert">' . $errors['field'] . '</div>';

            return view('editpost',
                [
                    'username' => $username,
                    'post' => $post,
                    'errorImgFormat' => $errorImgFormat,
                    'errorImg' => $errorImg,
                    'errorField' => $errorField,
                ]
                );
        }
    }
}

?>