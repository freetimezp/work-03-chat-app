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
    if (
        isset($DATA_OBJ->data_type)
        && $DATA_OBJ->data_type != "login"
        && $DATA_OBJ->data_type != "signup"
    ) {
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
} else if (isset($DATA_OBJ->data_type) && $DATA_OBJ->data_type == "contacts") {
    //contacts
    include("includes/contacts.php");
} else if (isset($DATA_OBJ->data_type) && $DATA_OBJ->data_type == "chats") {
    //chats
    include("includes/chats.php");
} else if (isset($DATA_OBJ->data_type) && $DATA_OBJ->data_type == "settings") {
    //settings
    include("includes/settings.php");
} else if (isset($DATA_OBJ->data_type) && $DATA_OBJ->data_type == "save_settings") {
    //settings
    include("includes/save_settings.php");
}
