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


$destination = "";

if (isset($_FILES['file']) && $_FILES['file']['name'] != "") {
    $allowed[] = 'image/jpeg';
    $allowed[] = 'image/png';

    if ($_FILES['file']['error'] == 0 && in_array($_FILES['file']['type'], $allowed)) {
        $filename = $_FILES['file']['tmp_name'];

        //check folder and create if not exist
        $folder = "uploads/";
        if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
        }
        $destination = $folder . $_FILES['file']['name'];
        move_uploaded_file($filename, $destination);

        $info->message = "Your image was uploaded!";
        $info->data_type = $data_type;
        echo json_encode($info);
    }
}



if ($data_type == "change_profile_image") {
    if ($destination != "") {
        //save to database
        $user_id = $_SESSION['user_id'];
        $query = "UPDATE users SET image = '$destination' WHERE user_id = '$user_id' LIMIT 1";
        $DB->write($query, []);
    }
} else if ($data_type == "send_image") {
    $arr['user_id'] = "null";
    if (isset($_POST['user_id'])) {
        $arr['user_id'] = addslashes($_POST['user_id']);
    }

    //save to database
    $arr['message'] = "";
    $arr['date'] = date("Y-m-d H:i:s");
    $arr['sender'] = $_SESSION['user_id'];
    $arr['msg_id'] = get_random_string_max(60);
    $arr['file'] = $destination;

    $arr2['sender'] = $_SESSION['user_id'];
    $arr2['receiver'] = $arr['user_id'];



    $query2 = "SELECT * FROM messages 
        WHERE (sender = :sender && receiver = :receiver) || (sender = :receiver && receiver = :sender) LIMIT 1";
    $result2 = $DB->read($query2, $arr2);

    if (is_array($result2)) {
        $arr['msg_id'] = $result2[0]->msg_id;
    }


    $query = "INSERT INTO messages (sender, receiver, message, date, msg_id, files) 
        VALUES (:sender, :user_id, :message, :date, :msg_id, :file)";
    $DB->write($query, $arr);
}


function get_random_string_max($length)
{
    $array = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 'q', 'w', 'e', 'r', 't', 'y', 'u', 'i', 'o', 'p', 'a', 's', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'z', 'x', 'c', 'v', 'b', 'n', 'm', 'Q', 'W', 'E', 'R', 'T', 'Y', 'U', 'I', 'O', 'P', 'A', 'S', 'D', 'F', 'G', 'H', 'J', 'K', 'L', 'Z', 'X', 'C', 'V', 'B', 'N', 'M');
    $text = '';

    $length = rand(4, $length);

    for ($i = 0; $i < $length; $i++) {
        $random = rand(0, 61);
        $text .= $array[$random];
    }

    return $text;
}
