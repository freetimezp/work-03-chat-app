<?php

session_start();
require_once("classes/autoload.php");

$DB = new Database();
$info = (object)[];

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


$data_type = "";

if (isset($_POST['data_type'])) {
    $data_type = $_POST['data_type'];
}


$destionation = "";

if (isset($_FILES['file']) && $_FILES['file']['name'] != "") {
    if ($_FILES['file']['error'] == 0) {
        $filename = $_FILES['file']['tmp_name'];

        //check folder and create if not exist
        $folder = "uploads/";
        if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
        }
        $destionation = $folder . $_FILES['file']['name'];
        move_uploaded_file($filename, $destionation);

        $info->message = "Your image was uploaded!";
        $info->data_type = $data_type;
        echo json_encode($info);
    }
}



if ($data_type == "change_profile_image") {
    if ($destionation != "") {
        //save to database
        $user_id = $_SESSION['user_id'];
        $query = "UPDATE users SET image = '$destionation' WHERE user_id = '$user_id' LIMIT 1";
        $DB->write($query, []);
    }
}
