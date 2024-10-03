<?php

$arr['user_id'] = "null";

if (isset($DATA_OBJ->find->user_id)) {
    $arr['user_id'] = $DATA_OBJ->find->user_id;
}

$query = "SELECT * FROM users WHERE user_id = :user_id LIMIT 1";

$result = $DB->read($query, $arr);


if (is_array($result)) {
    //user found
    $row = $result[0];

    $image = ($row->gender == 'male') ? 'assets/images/male.png' : 'assets/images/female.png';
    if (file_exists($row->image)) {
        $image = $row->image;
    }

    $row->image = $image;

    $mydata = "
    <style>
        #active_contact {
            display: flex;
            gap: 10px;
            border: thin solid #eee;
            padding: 10px;
            border-radius: 6px;
        }
        #active_contact img {
            width: 60px;
            height: 60px;
        }    
        #contact:hover {
            transform: scale(1.1);
        }
        .active_contact_name {
            text-transform: capitalize;
        }
        .active_contact_title {
            display: block;
            margin-bottom: 10px;
        }   

        #messages_holder {
            overflow-y: scroll;
            height: 600px;
        }            

        #message-left-wrapper {
            position: relative;
            margin: 10px;
            width: 350px;   
            float: left;
            background-color: #ffe2fe;
            border-radius: 40px 0 0 40px;
        }
        #message-left-wrapper.right {
            float: right;
            background-color: #e5f3d2;
            border-radius: 40px 0 0 40px;
        }
        #message-left-wrapper .badge-icon {
            position: absolute;
            width: 25px;
            height: 25px;
            border-radius: 50%;
            background-color: #8498a1;
            top: 0;
            left: 0;
            border: 2px solid #fff;
        }
        #message-left-wrapper.right .badge-icon {
            top: 0;
            left: unset;
            right: 0;
        }

        #message-left {
            display: flex;
            border: thin solid #ccc;
            gap: 10px;
            padding: 2px;
            border-radius: 40px 0 0 40px;
            box-shadow: 0px 0px 10px #aaa;
            width: 100%;
        }
        .right #message-left {
            flex-direction: row-reverse;
            justify-content: space-between;
            padding-left: 10px;
            border-radius: 0 40px 40px 0;
        }    

        #message-left img {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            border: 2px solid #fff;
        }  
        #message-left .contact_name {
            text-transform: capitalize;
            padding-bottom: 2px;
            color: #000;
            border-bottom: thin solid #ccc;
        }

        #message-left .content-message {
            padding-top: 5px;
            display: flex;
            flex-direction: column;
            align-items: start;
        }
        #message-left .contact_message, 
        #message-left .message_time {
            color: #000;
        }
        #message_btn_wrapper {
            width: 100%;
            min-height: 40px;
            padding: 40px 10px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        #message_btn_wrapper input {
            display: inline-block;
            border: none;            
            width: 100%;
            outline: none;
            height: 40px;
        }
        #message_btn_wrapper input[type=button] {
            background-color: blue;
            width: 100%;
            max-width: 100px;
            height: 40px;
            color: #fff;
            text-align:center;
            cursor: pointer;
        }

        #message_btn_wrapper label {
            color: #000;
            font-size: 20px;
            cursor: pointer;
        }
    </style>
    <span class='active_contact_title'>Now chating with:</span>
    <div id='active_contact'>
        <img src='$row->image' alt='profile'>
        <span class='active_contact_name'>$row->username</span>
    </div>";

    $messages = "<div id='messages_holder'>";
    $messages .= message_left($row);
    $messages .= message_right($row);

    $messages .=  "</div>    
    <div id='message_btn_wrapper'>   
        <div>
            <label for='message_file'>
                <i class='ri-attachment-line'></i>
                <input type='file' id='message_file' style='display: none;' />
            </label>
        </div>     
        <input type='text' value='' placeholder='Type your message' /> 
        <input type='button' value='Send'/> 
    </div>";

    $info->user = $mydata;
    $info->messages = $messages;
    $info->data_type = "chats";
    echo json_encode($info);
} else {
    //user not found
    $info->message = "Choose contact in list to chat...";
    $info->data_type = "chats";
    echo json_encode($info);
}
