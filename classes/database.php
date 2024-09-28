<?php

class Database
{
    private $con;

    //init class Database
    function __construct()
    {
        $con = $this->connect();
    }

    //connect to db
    private function connect()
    {
        $string = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;

        try {
            $connection = new PDO($string, DB_USER, DB_PASSWORD);
            return $connection;
        } catch (PDOException $e) {
            echo $e->getMessage();
            die;
        }

        return false;
    }

    //save data to database
    public function write($query, $data_array = [])
    {
        $con = $this->connect();
        $statement = $con->prepare($query);

        $check = $statement->execute($data_array);

        if ($check) return true;
        return false;
    }

    //read data from database
    public function read($query, $data_array = [])
    {
        $con = $this->connect();
        $statement = $con->prepare($query);

        $check = $statement->execute($data_array);

        if ($check) {
            $result = $statement->fetchAll(PDO::FETCH_OBJ);
            if (is_array($result) && count($result) > 0) {
                return $result;
            }

            return false;
        }
        return false;
    }

    //generate id
    public function generate_id($max)
    {
        $rand = "";
        $rand_count = rand(4, $max);

        for ($i = 0; $i < $rand_count; $i++) {
            $r = rand(0, 9);
            $rand .= $r;
        }

        return $rand;
    }
}
