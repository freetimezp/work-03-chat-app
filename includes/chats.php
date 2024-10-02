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
            border-radius: 50% 0;
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
    </style>
    <span class='active_contact_title'>Now chating with:</span>
    <div id='active_contact'>
        <img src='$image' alt='profile'>
        <span class='active_contact_name'>$row->username</span>
    </div>";

    $info->message = $mydata;
    $info->data_type = "chats";
    echo json_encode($info);
} else {
    //user not found
    $info->message = "Choose contact in list to chat...";
    $info->data_type = "chats";
    echo json_encode($info);
}
