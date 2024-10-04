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
}


function message_left($data, $row)
{
    $image = ($row->gender == 'male') ? 'assets/images/male.png' : 'assets/images/female.png';
    if (file_exists($row->image)) {
        $image = $row->image;
    }
    $row->image = $image;

    return "
        <div id='message-left-wrapper'>
            <div class='badge-icon'></div>
            <div id='message-left'>
                <img src='$row->image' alt='profile'>
                <div class='content-message'>
                    <span class='contact_name'>$row->username</span>
                    <span class='contact_message'>
                        $data->message
                    </span>
                    <span class='message_time'><small>" . date("jS M Y H:i:s a", strtotime($data->date)) . "</small></span>
                </div>
            </div>
        </div>    
    ";
}

function message_right($data, $row)
{
    $image = ($row->gender == 'male') ? 'assets/images/male.png' : 'assets/images/female.png';
    if (file_exists($row->image)) {
        $image = $row->image;
    }
    $row->image = $image;

    return "
        <div id='message-left-wrapper' class='right'>
            <div class='badge-icon'></div>
            <div id='message-left'>
                <img src='$row->image' alt='profile'>
                <div class='content-message'>
                    <span class='contact_name'>$row->username</span>
                    <span class='contact_message'>
                        $data->message
                    </span>
                    <span class='message_time'><small>" . date("jS M Y H:i:s a", strtotime($data->date)) . "</small></span>
                </div>
            </div>
        </div>   
    ";
}

function message_controls()
{
    return "
        </div>
        <div id='message_btn_wrapper'>   
            <div>
                <label for='message_file'>
                    <i class='ri-attachment-line'></i>
                    <input type='file' id='message_file' style='display: none; opacity: 0;' />
                </label>
            </div>     
            <input type='text' value='' placeholder='Type your message' id='message_text' onkeyup='enter_pressed(event)' /> 
            <input type='button' value='Send' onclick='send_message(event)'/> 
        </div> 
    ";
}
