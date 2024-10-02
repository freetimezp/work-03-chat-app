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

</style>
<div style="text-align:center;">
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
