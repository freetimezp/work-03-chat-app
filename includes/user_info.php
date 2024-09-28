<?php

$info = (object)[];

$data = false;

$data['user_id'] = $_SESSION['user_id'];

if ($error == "") {
    $query = "SELECT * FROM users WHERE user_id = :user_id LIMIT 1";

    $result = $DB->read($query, $data);

    if (is_array($result)) {
        $result = $result[0];
        $result->data_type = "user_info";
        echo json_encode($result);
    } else {
        $info->message = "no user found...";
        $info->data_type = "error";
        echo json_encode($info);
    }
} else {
    $info->message = $error;
    $info->data_type = "error";
    echo json_encode($info);
}
