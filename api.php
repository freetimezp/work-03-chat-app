<?php

require_once("classes/autoload.php");

$DB = new Database();

$DATA_ROW = file_get_contents("php://input");
$DATA_OBJ = json_decode($DATA_ROW);

if (isset($DATA_OBJ->data_type) && $DATA_OBJ->data_type == "signup") {
    //signup
    $data = false;
    $data['user_id'] = $DB->generate_id(20);
    $data['username'] = $DATA_OBJ->username;
    $data['email'] = $DATA_OBJ->email;
    $data['password'] = $DATA_OBJ->password;
    $data['date'] = date("Y-m-d H:i:s");

    $query = "INSERT INTO users (user_id,username,email,password,date) VALUES (:user_id,:username,:email,:password,:date)";

    $result = $DB->write($query, $data);

    if ($result) {
        echo "Your profile was created.";
    } else {
        echo "Your profile was NOT created.";
    }
}
