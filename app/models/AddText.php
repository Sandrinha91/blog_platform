<?php

namespace App\Models;

use App\Core\Database\Connection;
use PDO;
use App\Core\App;

class AddText
{
    protected $pdo;
    private $errors = [];
    private $suported_formats = ['image/png', 'image/jpeg', 'image/jpg'];

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }


    // file validation
    public function validateImage($file)
    {
        if(empty($file['name']))
        {
            $this->addError('image', 'You must select image!');
        }
        if( !in_array($file['type'], $this->suported_formats) )
        {
            $this->addError('format', 'Format file not supported!');
        }
    }

    // field validation
    public function validateField($value)
    {
        $val = trim($value);

        if(empty($val))
        {
            $this->addError('field', 'All fields must be filled!');
        }
    }

    //upload picture in folder
    public function storeImg($file)
    {
        $fileExt = explode('.',$file['name']);
        $fileActualExt = strtolower(end($fileExt));
        $uniqeName = uniqid('',true).".".$fileActualExt;
        move_uploaded_file( $file['tmp_name'], 'app/widgets/'. $uniqeName );
        $picture= 'app/widgets/'.$uniqeName;

        return $picture;
    } 
        
    //FUNCTION FOR ARRAY OF ERRORS(if some validation block code register an error, the same is added to array)
    private function addError($key, $val)
    {
        $this->errors[$key] = $val;
    }

    public function getError()
    {
        return $this->errors;
    }

    //get admin id
    private function getAdminId($username)
    {
        $sql = "SELECT id 
                FROM admin
                WHERE username = :username;";
        
        try
        {
            $statement = $this->pdo->prepare($sql);
            $statement->execute([':username' => $username]);
            $result = $statement->fetchAll(PDO::FETCH_CLASS);
            $result = (int)$result[0]->id;
            return $result;
        }
        catch(Exception $e)
        {
            die('Whoops, something went wrong' . $e->getMessage());
        }
    }

    //get admin id
    private function getCategoryId($lang, $category_name)
    {
        if( strpos($lang, 'en') !== false )
        {
            $sql = "SELECT id_category
                    FROM category_en
                    WHERE category_name = :category_name;";
        }
        elseif( strpos($lang, 'sr') !== false )
        {
            $sql = "SELECT id_category
                    FROM category_sr
                    WHERE category_name = :category_name;";
        }
        
        try
        {
            $statement = $this->pdo->prepare($sql);
            $statement->execute([':category_name' => $category_name]);
            $result = $statement->fetchAll(PDO::FETCH_CLASS);
            $result = (int)$result[0]->id_category;

            return $result;
        }
        catch(Exception $e)
        {
            die('Whoops, something went wrong' . $e->getMessage());
        }
    }

    //insert post data in db
    public function storePost($username, $lang, $heading, $review, $content, $picture_path, $author, $category_name, $time)
    {
        if( strpos($lang, 'en') !== false )
        {
            $sql = "INSERT INTO post_en (admin_id, category_id, post_name, post_review ,post_content, post_widget, post_author, post_time)
                    VALUES (:admin_id, :category_id, :post_name, :post_review , :post_content, :post_widget, :post_author, :post_time);";
            
            $c_id = App::get('addtext')->getCategoryId($lang, $category_name);
            var_dump($c_id);
        }
        elseif( strpos($lang, 'sr') !== false )
        {
            $sql = "INSERT INTO post_sr (admin_id, category_id, post_name, post_review , post_content, post_widget, post_author, post_time)
                    VALUES (:admin_id, :category_id, :post_name, :post_review , :post_content, :post_widget, :post_author, :post_time);";
            $c_id = App::get('addtext')->getCategoryId($lang, $category_name);
        }
        
        $id = App::get('addtext')->getAdminId($username);
        
        try
        {
            $statement = $this->pdo->prepare($sql);
            $statement->execute([':admin_id' => $id, ':category_id' => $c_id , ':post_name' => $heading, ':post_review' => $review, ':post_content' => $content, ':post_widget' => $picture_path, ':post_author' => $author, ':post_time' => $time ]);
        }
        catch(Exception $e)
        {
            die('Whoops, something went wrong' . $e->getMessage());
        }
    }

    //update post data in db
    public function updatePost($username, $lang, $heading, $content, $review, $picture_path, $author, $category_name, $p_id, $date)
    {
        if( strpos($lang, 'en') !== false )
        {
            $sql = "UPDATE post_en 
                    SET admin_id = :admin_id, category_id = :category_id, post_name = :post_name,post_review = :post_review, post_content = :post_content, post_widget =:post_widget, post_author =:post_author, post_time =:post_time
                    WHERE id = :id;";
            
            $c_id = App::get('addtext')->getCategoryId($lang, $category_name);
            //var_dump($c_id);
        }
        elseif( strpos($lang, 'sr') !== false )
        {
            $sql = "UPDATE post_sr 
                    SET admin_id = :admin_id, category_id = :category_id, post_name = :post_name, post_content = :post_content, post_review = :post_review,post_widget =:post_widget, post_author =:post_author, post_time =:post_time
                    WHERE id = :id;";
            $c_id = App::get('addtext')->getCategoryId($lang, $category_name);
        }
        
        $id = App::get('addtext')->getAdminId($username);
        
        try
        {
            $statement = $this->pdo->prepare($sql);
            $statement->execute([':admin_id' => $id, ':category_id' => $c_id , ':post_name' => $heading, ':post_review' => $review , ':post_content' => $content, ':post_widget' => $picture_path, ':post_author' => $author, ':id' => $p_id, ':post_time' => $date ]);
        }
        catch(Exception $e)
        {
            die('Whoops, something went wrong' . $e->getMessage());
        }
    }

}

?>