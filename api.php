<?php

session_start();

//check user logged in
$info = (object)[];

if (!isset($_SESSION['user_id'])) {
    if (isset($DATA_OBJ->data_type) && $DATA_OBJ->data_type != "login") {
        $info->logged_in = false;
        echo json_encode($info);
        die;
    }
}

require_once("classes/autoload.php");

$DB = new Database();

$DATA_ROW = file_get_contents("php://input");
$DATA_OBJ = json_decode($DATA_ROW);

$error = "";

if (isset($DATA_OBJ->data_type) && $DATA_OBJ->data_type == "signup") {
    //signup
    include("includes/signup.php");
} else if (isset($DATA_OBJ->data_type) && $DATA_OBJ->data_type == "login") {
    //login
    include("includes/login.php");
} else if (isset($DATA_OBJ->data_type) && $DATA_OBJ->data_type == "info") {
    //get user info from db
    echo json_encode("user info");
}
