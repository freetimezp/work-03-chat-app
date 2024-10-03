<?php

$myid = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE user_id != '$myid' LIMIT 10";
$myusers = $DB->read($query, []);

$mydata = '
<style>
    @keyframes appear {
        0%{
            opacity: 0;
            transform: translateY(100px);
        }
        100%{
            opacity: 1;
            transform: translateY(0px);
        }
    }

    #contact {
        cursor: pointer;
        transition: all 0.5s ease-out;
        animation: appear 0.5s ease-out;
    }
    #contact:hover {
        transform: scale(1.1);
    }
        #message-left-wrapper {
            position: relative;
            margin: 10px;
        }
        #message-left-wrapper .badge-icon {
            position: absolute;
            width: 25px;
            height: 25px;
            border-radius: 50%;
            background-color: #8498a1;
            top: -4px;
            left: -4px;
            border: 2px solid #fff;
        }
        #message-left {
            display: flex;
            flex-direction: column;
            border: thin solid #ccc;
            padding: 2px;
            border-radius: 0;
            box-shadow: 0px 0px 10px #aaa;
        }

        #message-left img {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            border: 2px solid #fff;
        }  
        #message-left .contact_name {
            text-transform: capitalize;
            color: #000;
        }
        #message-left .contact_message, 
        #message-left .message_time {
            display: none;
            opacity: 0;
        }
        #contact_holder {
            max-height: 700px;

        }
        #messages_holder {
            overflow-y: scroll;
            height: 600px;
        }  
        #message_btn_wrapper {
            display: none;
        }
</style>
<div style="text-align:center;" id="contact_holder">
';

if (is_array($myusers)) {
    foreach ($myusers as $row) {
        $image = ($row->gender == 'male') ? 'assets/images/male.png' : 'assets/images/female.png';
        if (file_exists($row->image)) {
            $image = $row->image;
        }

        $mydata .= "
        <div id='contact' onclick='start_chat(event)' user_id='$row->user_id'>
            <img src='$image' alt='profile'>
            <br>
            <span>$row->username</span>
        </div>";
    }
}

$mydata .= '</div>';

//$result = $result[0];
$info->message = $mydata;
$info->data_type = "contacts";
echo json_encode($info);

die;

$info->message = "no contacts were found...";
$info->data_type = "error";
echo json_encode($info);
