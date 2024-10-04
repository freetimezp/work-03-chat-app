<?php

$arr['user_id'] = "null";

if (isset($DATA_OBJ->find->user_id)) {
    $arr['user_id'] = $DATA_OBJ->find->user_id;
}

$refresh = false;
if ($DATA_OBJ->data_type == 'chats_refresh') {
    $refresh = true;
}

$query = "SELECT * FROM users WHERE user_id = :user_id LIMIT 1";

$result = $DB->read($query, $arr);
$messages = '';
$mydata = '';

if (is_array($result)) {
    //user found
    $row = $result[0];

    $image = ($row->gender == 'male') ? 'assets/images/male.png' : 'assets/images/female.png';
    if (file_exists($row->image)) {
        $image = $row->image;
    }

    $row->image = $image;

    if (!$refresh) {
        $mydata = "
        <span class='active_contact_title'>Now chating with:</span>
        <div id='active_contact'>
            <img src='$row->image' alt='profile'>
            <span class='active_contact_name'>$row->username</span>
        </div>";
    }

    if (!$refresh) {
        $messages = "<div id='messages_holder'>";
    }

    //read messages from database
    $a['sender'] = $_SESSION['user_id'];
    $a['receiver'] = $arr['user_id'];

    $query2 = "SELECT * FROM messages 
        WHERE (sender = :sender && receiver = :receiver) || (sender = :receiver && receiver = :sender) 
        ORDER BY id DESC
        LIMIT 10";
    $result2 = $DB->read($query2, $a);

    if (is_array($result2)) {
        $result2 = array_reverse($result2);

        foreach ($result2 as $data) {
            $myuser = $DB->get_user($data->sender);

            $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
            if ($user_id == $data->sender) {
                $messages .= message_right($data, $myuser);
            } else {
                $messages .= message_left($data, $myuser);
            }
        }
    }

    if (!$refresh) {
        $messages .= message_controls();
    }

    $info->user = $mydata;
    $info->messages = $messages;

    $info->data_type = "chats";
    if ($refresh) {
        $info->data_type = "chats_refresh";
    }
    echo json_encode($info);
} else {
    //user not found
    //read messages from database
    $a['user_id'] = $_SESSION['user_id'];

    $query2 = "SELECT * FROM messages 
        WHERE sender = :user_id || receiver = :user_id
        GROUP BY msg_id  
        ORDER BY id DESC 
        LIMIT 10";
    $result2 = $DB->read($query2, $a);

    $mydata = "<span class='active_contact_title'>Your previous chats:</span>";

    if (is_array($result2)) {
        $result2 = array_reverse($result2);


        foreach ($result2 as $data) {
            $other_user = $data->sender;
            if ($data->sender == $_SESSION['user_id']) {
                $other_user = $data->receiver;
            }

            $myuser = $DB->get_user($other_user);

            $image = ($myuser->gender == 'male') ? 'assets/images/male.png' : 'assets/images/female.png';
            if (file_exists($myuser->image)) {
                $image = $myuser->image;
            }
            $data->image = $image;

            $mydata .= "
            <div id='active_contact' style='margin-bottom: 10px;'>
                <img src='$data->image' alt='profile'>
                <span class='active_contact_name'>$myuser->username</span>
            </div>";
        }
    }

    $info->user = $mydata;
    $info->messages = "";
    $info->data_type = "chats";

    echo json_encode($info);
}
