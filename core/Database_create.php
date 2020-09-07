<?php
namespace App\Core;

class Create_database
{
    //public static $created = false;

    public static function create_database($db)
    {

        try {
            $sql ="CREATE TABLE IF NOT EXISTS admin(
                       id INT UNSIGNED AUTO_INCREMENT,
                       username VARCHAR(50) NOT NULL,
                       email VARCHAR(50) NOT NULL,
                       password VARCHAR(50) NOT NULL,
                       is_admin BOOLEAN,
                       token_value VARCHAR(50) NOT NULL,
                       token_time VARCHAR(50) NOT NULL,
                       PRIMARY KEY(id)
                   ) ENGINE = InnoDB;";

            $sql .= "CREATE TABLE IF NOT EXISTS blog_database.category_sr
                    (
                        id INT UNSIGNED AUTO_INCREMENT,
                        category_name VARCHAR(200),
                        PRIMARY KEY(id)
                    ) ENGINE = InnoDB;";

            $sql .= "CREATE TABLE IF NOT EXISTS blog_database.post_sr
                    (
                        id INT UNSIGNED AUTO_INCREMENT,
                        admin_id INT UNSIGNED NOT NULL,
                        category_id INT UNSIGNED NOT NULL,
                        post_name VARCHAR(200),
                        post_content VARCHAR(2000),
                        post_widget VARCHAR(200),
                        post_author VARCHAR(200),
                        post_language VARCHAR(200),
                        post_category VARCHAR(200),
                        post_created_at timestamp NOT NULL DEFAULT current_timestamp,
                        PRIMARY KEY(id),
                        FOREIGN KEY (admin_id) REFERENCES admin(id),
                        FOREIGN KEY (category_id) REFERENCES category_sr(id)   
                    ) ENGINE = InnoDB;";

            $sql .= "CREATE TABLE IF NOT EXISTS blog_database.category_en
                    (
                        id INT UNSIGNED AUTO_INCREMENT,
                        category_name VARCHAR(200),
                        PRIMARY KEY(id)
                    ) ENGINE = InnoDB;";

            $sql .= "CREATE TABLE IF NOT EXISTS blog_database.post_en
                    (
                        id INT UNSIGNED AUTO_INCREMENT,
                        admin_id INT UNSIGNED NOT NULL,
                        category_id INT UNSIGNED NOT NULL,
                        post_name VARCHAR(200),
                        post_content VARCHAR(2000),
                        post_widget VARCHAR(200),
                        post_author VARCHAR(200),
                        post_language VARCHAR(200),
                        post_category VARCHAR(200),
                        post_created_at timestamp NOT NULL DEFAULT current_timestamp,
                        PRIMARY KEY(id),
                        FOREIGN KEY (admin_id) REFERENCES admin(id),
                        FOREIGN KEY (category_id) REFERENCES category_en(id)   
                    ) ENGINE = InnoDB;";
        
            $db->exec($sql);
            
            //Create_database::isCreated(true);

            
       
       } catch(PDOException $e) {
           echo $e->getMessage();//Remove or change message in production code
       }
    }

    // public static function isCreated($value)
    // {
    //    var_dump(Create_database::$created = $value);
    //    Create_database::$created = $value;
    // }

}

?>