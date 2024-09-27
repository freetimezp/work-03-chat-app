<?php 

Class Database 
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
        $string = 'mysql:host=localhost;dbname=chat_app3';

        try {
            $connection = new PDO($string, DB_USER, DB_PASSWORD);
            return $connection;
        } catch (DPOException $e) {
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

        foreach($data_array as $key => $value) {
            $statement->bindValue(':'.$key, $value);
        }

        $check = $statement->execute();    

        if($check) return true;        

        return false;
    }

    //generate id
    public function generate_id($max) 
    {
        $rand = "";
        $rand_count = rand(4, $max);

        for($i = 0; $i < $rand_count; $i++) {
            $r = rand(0, 9);
            $rand .= $r;
        }

        return $rand;
    }
}