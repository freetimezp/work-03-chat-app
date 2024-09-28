<?php

$info = (object)[];

//login
$data = false;
$error = "";

if (empty($DATA_OBJ->email)) {
    $error = "Please, fill email..";
}
if (empty($DATA_OBJ->password)) {
    $error = "Please, fill password..";
}

$data['email'] = $DATA_OBJ->email;

if ($error == "") {
    $query = "SELECT * FROM users WHERE email = :email LIMIT 1";

    $result = $DB->read($query, $data);

    if (is_array($result)) {
        $result = $result[0];

        if ($result->password == $DATA_OBJ->password) {
            $_SESSION['user_id'] = $result->user_id;

            $info->logged_in = true;
            $info->message = "Logged In. Success.";
            $info->data_type = "info";

            echo json_encode($info);
        } else {
            $info->message = "Wrong password...";
            $info->data_type = "error";
            echo json_encode($info);
        }
    } else {
        $info->message = "Wrong email...";
        $info->data_type = "error";
        echo json_encode($info);
    }
} else {
    $info->message = $error;
    $info->data_type = "error";
    echo json_encode($info);
}
