<?php

namespace App\Core\Database;

use PDO;

class QueryBuilder
{
    protected $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // public static function getConection()
    // {
    //     return $this->pdo;
    // }




    // public function selectAll($table)
    // {
    //     $statement = $this->pdo->prepare("select * from {$table}");

    //     $statement->execute();

    //     return $statement->fetchAll(PDO::FETCH_CLASS);
    // }

    public function insert($table, $parameters)
    {
        //array_keys($parameters);
        //insert into table (column names) values ( value )
        $sql = sprintf(
            'insert into %s (%s) values (%s)',
            $table,
            implode( ',', array_keys($parameters) ),
            ':' . implode( ', :', array_keys($parameters) )
            
        );

        
        try
        {
            $statement = $this->pdo->prepare($sql);

            //die(var_dump($sql));
            //die(var_dump(array_keys($parameters)));
    
            $statement->execute($parameters);
        }
        catch(Exception $e)
        {
            die('Whoops, something went wrong' . $e->getMessage());
        }
    }
}