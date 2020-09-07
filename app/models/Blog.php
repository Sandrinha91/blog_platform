<?php

namespace App\Models;

use App\Core\Database\Connection;
use PDO;


class Blog
{
    protected $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    //COUNT select all texts from all categories
    public function selectAllText($table)
    {
        if( strpos($table, 'en') !== false )
        {
            $sql = "SELECT COUNT(id) AS NumberOfPost FROM post_en";
        }
        elseif( strpos($table, 'sr') !== false )
        {
            $sql = "SELECT COUNT(id) AS NumberOfPost FROM post_sr";
        }
        
        try
        {
            $statement = $this->pdo->prepare($sql);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_CLASS);
            $result = (int)$result[0]->NumberOfPost;
            return $result;
        }
        catch(Exception $e)
        {
            die('Whoops, something went wrong' . $e->getMessage());
        }
    }

    //select texts from all categories with limits
    public function selectAllTextLimit($table,$downLimit, $upLimit)
    {
        if( strpos($table, 'en') !== false )
        {
            $sql = "SELECT * FROM post_en
                    JOIN category_en
                    ON category_en.id_category = post_en.category_id
                    ORDER BY post_created_at DESC
                    LIMIT $downLimit,$upLimit";
        }
        elseif( strpos($table, 'sr') !== false )
        {
            $sql = "SELECT * FROM post_sr
                    JOIN category_sr
                    ON category_sr.id_category = post_sr.category_id
                    ORDER BY post_created_at DESC
                    LIMIT $downLimit,$upLimit";
        }
        
        try
        {
            $statement = $this->pdo->prepare($sql);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_CLASS);
        }
        catch(Exception $e)
        {
            die('Whoops, something went wrong' . $e->getMessage());
        }
    }

    //select all categories
    public function selectAllCategories($table)
    {
        if( strpos($table, 'en') !== false )
        {
            $sql = "SELECT * FROM category_en";
        }
        elseif( strpos($table, 'sr') !== false )
        {
            $sql = "SELECT * FROM category_sr";
        }
        
        try
        {
            $statement = $this->pdo->prepare($sql);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_CLASS);
        }
        catch(Exception $e)
        {
            die('Whoops, something went wrong' . $e->getMessage());
        }
    }

    //COUNT texts from selected category
    public function countFromCategory($table,$id)
    {
        if( strpos($table, 'en') !== false )
        {
            $sql = "SELECT COUNT(id) AS NumberOfPost FROM post_en WHERE category_id = :category_id";
        }
        elseif( strpos($table, 'sr') !== false )
        {
            $sql = "SELECT COUNT(id) AS NumberOfPost FROM post_sr WHERE category_id = :category_id";
        }

        try
        {
            $statement = $this->pdo->prepare($sql);
            $statement->execute([':category_id' => $id]);
            $result = $statement->fetchAll(PDO::FETCH_CLASS);
            $result = (int)$result[0]->NumberOfPost;
            return $result;
        }
        catch(Exception $e)
        {
            die('Whoops, something went wrong' . $e->getMessage());
        }
    }

    //SELECT texts from selected category
    public function selectPostsFromCategory($table,$id,$downLimit,$upLimit)
    {
        if( strpos($table, 'en') !== false )
        {
            $sql = "SELECT * FROM post_en
                    JOIN category_en
                    ON category_en.id_category = post_en.category_id
                    WHERE category_id = :category_id
                    ORDER BY post_created_at DESC
                    LIMIT $downLimit,$upLimit";
        }
        elseif( strpos($table, 'sr') !== false )
        {
            $sql = "SELECT * FROM post_sr
                    JOIN category_sr
                    ON category_sr.id_category = post_sr.category_id
                    WHERE category_id = :category_id
                    ORDER BY post_created_at DESC
                    LIMIT $downLimit,$upLimit";
        }

        try
        {
            $statement = $this->pdo->prepare($sql);
            $statement->execute([':category_id' => $id]);
            $result = $statement->fetchAll(PDO::FETCH_CLASS);
            return $result;
        }
        catch(Exception $e)
        {
            die('Whoops, something went wrong' . $e->getMessage());
        }
    }

    // select/read single texts by ID 
    public function selectText($table,$id)
    {
        if( strpos($table, 'en') !== false )
        {
            $sql = "SELECT * FROM post_en
                    JOIN category_en
                    ON category_en.id_category = post_en.category_id
                    WHERE id = :id";
        }
        elseif( strpos($table, 'sr') !== false )
        {
            $sql = "SELECT * FROM post_sr
                    JOIN category_sr
                    ON category_sr.id_category = post_sr.category_id
                    WHERE id = :id";
        }

        try
        {
            $statement = $this->pdo->prepare($sql);
            $statement->execute([':id' => $id]);
            return $statement->fetchAll(PDO::FETCH_CLASS);
        }
        catch(Exception $e)
        {
            die('Whoops, something went wrong' . $e->getMessage());
        }
    }

    // select/ random textsingle texts by ID 
    public function selectAllPostID($table,$id,$c_id)
    {
        $arrayId = array();

        if( strpos($table, 'en') !== false )
        {
            $sql = "SELECT id FROM post_en
                    WHERE id != :id AND category_id = :category_id";
        }
        elseif( strpos($table, 'sr') !== false )
        {
            $sql = "SELECT id FROM post_sr
                    WHERE id != :id AND category_id = :category_id";
        }

        try
        {
            $statement = $this->pdo->prepare($sql);
            $statement->execute([':id' => $id, ':category_id' => $c_id]);
            $result =$statement->fetchAll(PDO::FETCH_CLASS);

            foreach( $result as $elem )
            {
                array_push($arrayId, $elem->id);
            }

            return $arrayId;
            //return $result;
        }
        catch(Exception $e)
        {
            die('Whoops, something went wrong' . $e->getMessage());
        }
    }

    // select related texts by ID 
    public function selectRelatedText($table,$id)
    {
        if( strpos($table, 'en') !== false )
        {
            $sql = "SELECT * FROM post_en
                    JOIN category_en
                    ON category_en.id_category = post_en.category_id
                    WHERE id = :id";
        }
        elseif( strpos($table, 'sr') !== false )
        {
            $sql = "SELECT * FROM post_sr
                    JOIN category_sr
                    ON category_sr.id_category = post_sr.category_id
                    WHERE id = :id";
        }

        try
        {
            $statement = $this->pdo->prepare($sql);
            $statement->execute([':id' => $id]);
            $result = $statement->fetchAll(PDO::FETCH_CLASS);
            $result = $result[0];
            return $result;
        }
        catch(Exception $e)
        {
            die('Whoops, something went wrong' . $e->getMessage());
        }
    }

    // select/ random textsingle texts by ID  from any category
    public function selectAllPostIDForAny($table,$id,$c_id)
    {
        $arrayId = array();

        if( strpos($table, 'en') !== false )
        {
            $sql = "SELECT id FROM post_en
                    WHERE (id != :id AND category_id != :category_id)";
        }
        elseif( strpos($table, 'sr') !== false )
        {
            $sql = "SELECT id FROM post_sr
                    WHERE (id != :id AND category_id != :category_id)";
        }

        try
        {
            $statement = $this->pdo->prepare($sql);
            $statement->execute([':id' => $id, ':category_id' => $c_id]);
            $result =$statement->fetchAll(PDO::FETCH_CLASS);

            foreach( $result as $elem )
            {
                array_push($arrayId, $elem->id);
            }

            return $arrayId;
            //return $result;
        }
        catch(Exception $e)
        {
            die('Whoops, something went wrong' . $e->getMessage());
        }
    }  
}

?>