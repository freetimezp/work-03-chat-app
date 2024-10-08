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
} else if (
    isset($DATA_OBJ->data_type)
    && ($DATA_OBJ->data_type == "chats" || $DATA_OBJ->data_type == "chats_refresh")
) {
    //chats
    include("includes/chats.php");
} else if (isset($DATA_OBJ->data_type) && $DATA_OBJ->data_type == "settings") {
    //settings
    include("includes/settings.php");
} else if (isset($DATA_OBJ->data_type) && $DATA_OBJ->data_type == "save_settings") {
    //settings
    include("includes/save_settings.php");
} else if (isset($DATA_OBJ->data_type) && $DATA_OBJ->data_type == "send_message") {
    //send message
    include("includes/send_message.php");
} else if (isset($DATA_OBJ->data_type) && $DATA_OBJ->data_type == "delete_message") {
    //delete message
    include("includes/delete_message.php");
} else if (isset($DATA_OBJ->data_type) && $DATA_OBJ->data_type == "delete_thread") {
    //delete thread
    include("includes/delete_thread.php");
}

$a = '';

function message_left($data, $row)
{
    $image = ($row->gender == 'male') ? 'assets/images/male.png' : 'assets/images/female.png';
    if (file_exists($row->image)) {
        $image = $row->image;
    }
    $row->image = $image;

    $a = "<div id='message-left-wrapper'>
    <div class='badge-icon'>";

    if ($data->seen) {
        $a .= "<i class='ri-check-double-line'></i>";
    } else if ($data->received) {
        $a .= "<i class='ri-check-double-line seen'></i>";
    }

    $a .= "</div>
            <div id='message-left'>
                <img src='$row->image' alt='profile' class='contact_profile_image'>
                <div class='content-message'>
                    <span class='contact_name'>$row->username</span>
                    <span class='contact_message'>
                        $data->message
                    </span>";

    if ($data->files != "" && file_exists($data->files)) {
        $a .= "<img src='$data->files' class='contact_message_image' onclick='image_show(event)' />";
    }

    $a .= "<span class='message_time'><small>" . date("jS M Y H:i:s a", strtotime($data->date)) . "</small></span>
                </div>
                <i class='ri-delete-bin-fill' id='trash' onclick='delete_message(event)' msgId='$data->id'></i>
            </div>
        </div>   
    ";

    return $a;
}

function message_right($data, $row)
{
    $image = ($row->gender == 'male') ? 'assets/images/male.png' : 'assets/images/female.png';
    if (file_exists($row->image)) {
        $image = $row->image;
    }
    $row->image = $image;

    $a = "<div id='message-left-wrapper' class='right'>
            <div class='badge-icon'>";

    if ($data->seen) {
        $a .= "<i class='ri-check-double-line seen'></i>";
    } else {
        $a .= "<i class='ri-check-double-line'></i>";
    }

    $a .= "</div>
            <div id='message-left'>
                <img src='$row->image' alt='profile' class='contact_profile_image'>
                <div class='content-message'>
                    <span class='contact_name'>$row->username</span>
                    <span class='contact_message'>
                        $data->message
                    </span>";
    if ($data->files != "" && file_exists($data->files)) {
        $a .= "<img src='$data->files' class='contact_message_image' onclick='image_show(event)' />";
    }
    $a .= "<span class='message_time'><small>" . date("jS M Y H:i:s a", strtotime($data->date)) . "</small></span>
                </div>
                <i class='ri-delete-bin-fill' id='trash' onclick='delete_message(event)' msgId='$data->id'></i>
            </div>
        </div>   
    ";

    return $a;
}

function message_controls()
{
    return "
        </div>
        <span class='delete-thread' onclick='delete_thread(event)'>Delete this thread</span>
        <div id='message_btn_wrapper'>   
            <div>
                <label for='message_file'>
                    <i class='ri-attachment-line'></i>
                    <input type='file' id='message_file' style='display: none; opacity: 0;' 
                        onchange='send_image(this.files)' />
                </label>
            </div>     
            <input type='text' value='' placeholder='Type your message' id='message_text' onkeyup='enter_pressed(event)' /> 
            <input type='button' value='Send' onclick='send_message(event)'/> 
        </div> 
    ";
}
