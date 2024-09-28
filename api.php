<?php

session_start();
require_once("classes/autoload.php");

//check user logged in
$info = (object)[];
$DATA_ROW = file_get_contents("php://input");
$DATA_OBJ = json_decode($DATA_ROW);

$DB = new Database();

$error = "";

if (!isset($_SESSION['user_id'])) {
    if (isset($DATA_OBJ->data_type) && $DATA_OBJ->data_type != "login") {
        $info->logged_in = false;
        echo json_encode($info);
        die;
    }
}




if (isset($DATA_OBJ->data_type) && $DATA_OBJ->data_type == "signup") {
    //signup
    include("includes/signup.php");
} else if (isset($DATA_OBJ->data_type) && $DATA_OBJ->data_type == "login") {
    //login
    include("includes/login.php");
} else if (isset($DATA_OBJ->data_type) && $DATA_OBJ->data_type == "logout") {
    //logout
    include("includes/logout.php");
} else if (isset($DATA_OBJ->data_type) && $DATA_OBJ->data_type == "user_info") {
    //get user info from db
    include("includes/user_info.php");
}
