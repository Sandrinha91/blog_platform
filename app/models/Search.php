<?php

namespace App\Models;

use App\Core\Database\Connection;
use PDO;
use App\Core\App;

class Search
{
    protected $pdo;
    private $errors = [];

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    //username validation
    public function validateSearch($search)
    {
        $val = trim($search);

        if(empty($val))
        {
        $this->addError('search', 'You must enter a value for reserch!');
        } 
        
    }

    //FUNCTION FOR ARRAY OF ERRORS(if some validation block code register an error, the same is added to array)
    public function addError($key, $val)
    {
        $this->errors[$key] = $val;
    }

    public function getSearchError()
    {
        return $this->errors;
    }

    // count posts whitch include given keyword
    public function countPosts($lang, $key)
    {
        $key = '%' . $key . '%';

        if( strpos($lang, 'en') !== false)
        {
            $sql = "SELECT COUNT(id) as NumberOfPost FROM post_en
                    WHERE post_en.post_name  LIKE :post_name;";
        }
        elseif ( strpos($lang, 'sr') !== false )
        {
            $sql = "SELECT COUNT(id) as NumberOfPost FROM post_sr
                    WHERE post_sr.post_name  LIKE :post_name;";
        }

        try
        {
            $statement = $this->pdo->prepare($sql);
            $statement->execute([':post_name' => $key]);
            $result = $statement->fetchAll(PDO::FETCH_CLASS);
            //die(var_dump($result));
            $result = (int)$result[0]->NumberOfPost;
            return $result;
        }
        catch(Exception $e)
        {
            die('Whoops, something went wrong' . $e->getMessage());
        }
    }

    // count posts whitch include given keyword in DEFINED category
    public function countPostsByCategory($lang, $key, $c_id)
    {
        $key = '%' . $key . '%';

        if( strpos($lang, 'en') !== false)
        {
            $sql = "SELECT COUNT(id) as NumberOfPost FROM post_en
                    WHERE post_en.post_name  LIKE :post_name AND category_id = :category_id;";
        }
        elseif ( strpos($lang, 'sr') !== false )
        {
            $sql = "SELECT COUNT(id) as NumberOfPost FROM post_sr
                    WHERE post_sr.post_name  LIKE :post_name AND category_id = :category_id ;";
        }

        try
        {
            $statement = $this->pdo->prepare($sql);
            $statement->execute([':post_name' => $key, ':category_id' => $c_id]);
            $result = $statement->fetchAll(PDO::FETCH_CLASS);
            $result = (int)$result[0]->NumberOfPost;
            return $result;
        }
        catch(Exception $e)
        {
            die('Whoops, something went wrong' . $e->getMessage());
        }
    }

    // search in all posts and retrive the ones which include given keyword
    private function searchPost($table, $key, $downLimit,$upLimit)
    {
        $key = '%' . $key . '%';
        if( strpos($table, 'en') !== false)
        {
            $sql = "SELECT *
                    FROM post_en
                    JOIN category_en
                    ON category_en.id_category = post_en.category_id
                    WHERE post_en.post_name  LIKE :post_name
                    ORDER BY post_en.post_created_at DESC
                    LIMIT $downLimit,$upLimit;";
        }
        elseif ( strpos($table, 'sr') !== false )
        {
            $sql = "SELECT *
                    FROM post_sr
                    JOIN category_sr
                    ON category_sr.id_category = post_sr.category_id
                    WHERE post_sr.post_name  LIKE :post_name
                    ORDER BY post_sr.post_created_at DESC
                    LIMIT $downLimit,$upLimit;";
        }

        try
        {
            $statement = $this->pdo->prepare($sql);
            $statement->execute([':post_name' => $key]);
            $result = $statement->fetchAll(PDO::FETCH_CLASS);
            return $result;
        }
        catch(Exception $e)
        {
            die('Whoops, something went wrong' . $e->getMessage());
        }
    }

    //RETURN DATA for search in all posts and retrive the ones which include given keyword
    public static function returnSearchPosts($table, $key, $downLimit,$upLimit)
    {
        $result = App::get('search')->searchPost($table, $key, $downLimit,$upLimit);
        return $result;
    }

    // search posts by keyword in defined category
    private function searchPostInCategory($table, $key, $id, $downLimit, $upLimit)
    {
        $key = '%' . $key . '%';
        if( strpos($table, 'en') !== false)
        {
            $sql = "SELECT *
                    FROM post_en
                    JOIN category_en
                    ON category_en.id_category = post_en.category_id
                    WHERE post_en.post_name  LIKE :post_name AND category_id = :category_id
                    ORDER BY post_en.post_created_at DESC
                    LIMIT $downLimit,$upLimit ;";
        }
        elseif ( strpos($table, 'sr') !== false )
        {
            $sql = "SELECT *
                    FROM post_sr
                    JOIN category_sr
                    ON category_sr.id_category = post_sr.category_id
                    WHERE post_sr.post_name  LIKE :post_name AND category_id = :category_id 
                    ORDER BY post_sr.post_created_at DESC
                    LIMIT $downLimit,$upLimit;";
        }

        try
        {
            $statement = $this->pdo->prepare($sql);
            $statement->execute([':post_name' => $key , ':category_id' => $id]);
            $result = $statement->fetchAll(PDO::FETCH_CLASS);
            return $result;
        }
        catch(Exception $e)
        {
            die('Whoops, something went wrong' . $e->getMessage());
        }
    }

    // RETURN RESUKT FOR search posts by keyword in defined category
    public static function returnPostsFromCategoryId($table,$key,$id,$downLimit,$upLimit)
    {
        $result = App::get('search')->searchPostInCategory($table, $key, $id, $downLimit, $upLimit);
        return $result;
    }

}

?>