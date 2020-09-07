<?php

namespace App\Models;

use App\Core\Database\Connection;
use PDO;
use App\Core\App;

class AdminPost
{
    protected $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    //select all texts from all categories
    private function selectAll($table)
    {
        if( strpos($table, 'en') !== false)
        { 
            $sql = "SELECT * FROM post_en
                    INNER JOIN category_en
                    ON category_en.id_category = post_en.category_id
                    ORDER BY post_en.post_created_at DESC;";
        }
        elseif( strpos($table, 'sr') !== false)
        {
            $sql = "SELECT * FROM post_sr
                    INNER JOIN category_sr
                    ON category_sr.id_category = post_sr.category_id
                    ORDER BY post_sr.post_created_at DESC";
        }
        
        try
        {
            $statement = $this->pdo->prepare($sql);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_CLASS);
            //var_dump($result);
            return $result;

        }
        catch(Exception $e)
        {
            die('Whoops, something went wrong' . $e->getMessage());
        }   
    }

    //geter for all post
    public static function getSellectAllResult($table)
    {
        $result = App::get('post')->selectAll($table);
        return $result;
    }

    //get post category
    private function getCategoryByPostId($id, $table)
    {
        if( strpos($table, 'en') !== false)
        {
            //var_dump($table);
            $sql = "SELECT post_en.category_id
                    FROM post_en
                    JOIN category_en
                    ON category_en.id_category = post_en.category_id
                    WHERE post_en.id  = :id
                    ;";
        }
        elseif ( strpos($table, 'sr') !== false )
        {
            //var_dump($table);
            $sql = "SELECT post_sr.category_id 
                    FROM post_sr
                    JOIN category_sr
                    ON category_sr.id_category = post_sr.category_id
                    WHERE post_sr.id  = :id
                    ;";
        }

        
        try
        {
            $statement = $this->pdo->prepare($sql);
            $statement->execute([':id' => $id]);
            $result = $statement->fetchAll(PDO::FETCH_CLASS);
            return $result;
        }
        catch(Exception $e)
        {
            die('Whoops, something went wrong' . $e->getMessage());
        }
    }

    //return post category
    public static function returnCategoryByPostId($id, $table)
    {
        $result = App::get('post')->getCategoryByPostId($id, $table);
        $result = (int)$result[0]->category_id;
        return $result;
    }

    //select post by category
    private function selectPostByCategory($table,$category, $downLimit, $upLimit)
    {
        if( strpos($table, 'en') !== false)
        {
            $sql = "SELECT * FROM post_en
                    INNER JOIN category_en
                    ON category_en.id_category = post_en.category_id
                    WHERE id_category = :id_category
                    ORDER BY post_en.post_created_at DESC
                    LIMIT $downLimit,$upLimit;";
        }
        elseif( strpos($table, 'sr') !== false)
        {
            $sql = "SELECT * FROM post_sr
                    INNER JOIN category_sr
                    ON category_sr.id_category = post_sr.category_id
                    WHERE id_category = :id_category
                    ORDER BY post_sr.post_created_at DESC
                    LIMIT $downLimit,$upLimit;";
        }
        
        try
        {
            $statement = $this->pdo->prepare($sql);
            $statement->execute([':id_category' => $category]);
            $result = $statement->fetchAll(PDO::FETCH_CLASS);
            return $result;
        }
        catch(Exception $e)
        {
            die('Whoops, something went wrong' . $e->getMessage());
        }
    }

    //geter for all post by category
    public static function getPostByCategory($table,$category,$downLimit, $upLimit)
    {
        $result = App::get('post')->selectPostByCategory($table,$category,$downLimit, $upLimit);
        return $result;
    }

    //delete post by id
    private function deletePostById($id, $lang)
    {
        if( strpos($lang, 'en') !== false )
        {
            //var_dump($lang);
            $sql = "DELETE FROM post_en
                    WHERE id = :id;";
        }
        elseif( strpos($lang, 'sr') !== false )
        {
            var_dump($lang);
            $sql = "DELETE FROM post_sr
                    WHERE id = :id;";
        }

        try
        {
            $statement = $this->pdo->prepare($sql);
            $statement->execute([':id' => $id]);
        }
        catch(Exception $e)
        {
            die('Whoops, something went wrong' . $e->getMessage());
        }
    }

    //delete post by id
    public static function getDeletePost($id, $lang)
    {
        $result = App::get('post')->deletePostById($id, $lang);
    }

    // select/read single texts by ID 
    private function selectText($table,$id)
    {
        if( strpos($table, 'en') !== false)
        {
            $sql = "SELECT * FROM post_en
                    INNER JOIN category_en
                    ON category_en.id_category = post_en.category_id
                    WHERE id = :id;";
        }
        elseif( strpos($table, 'sr') !== false)
        {
            $sql = "SELECT * FROM post_sr
                    INNER JOIN category_sr
                    ON category_sr.id_category = post_sr.category_id
                    WHERE id = :id;";
        }
        
        try
        {
            $statement = $this->pdo->prepare($sql);
            $statement->execute([':id' => $id]);
            $result = $statement->fetchAll(PDO::FETCH_CLASS);
            return $result;
        }
        catch(Exception $e)
        {
            die('Whoops, something went wrong' . $e->getMessage());
        }
    }

    //geter for post by id
    public static function getSelectedText($table,$id)
    {
        $result = App::get('post')->selectText($table,$id);
        return $result;
    }

}

?>