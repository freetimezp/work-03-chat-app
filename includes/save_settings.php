<?php

$info = (object)[];

//set timeout 1s
//sleep(1);

//signup
$data = false;
$data['user_id'] = $_SESSION['user_id'];

//validation username
$data['username'] = $DATA_OBJ->username;
if (empty($DATA_OBJ->username)) {
    $error .= "Please, enter a valid username. <br>";
} else {
    if (strlen($DATA_OBJ->username) < 4) {
        $error .= "Username must be at least 4 characters. <br>";
    }
    if (!preg_match("/^[a-z A-Z 0-9]*$/", $DATA_OBJ->username)) {
        $error .= "Username must contain only characters and numbers. <br>";
    }
}

//validation email
$data['email'] = $DATA_OBJ->email;
if (empty($DATA_OBJ->email)) {
    $error .= "Please, enter a valid email. <br>";
} else {
    if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $DATA_OBJ->email)) {
        $error .= "Please, check a characters in email. <br>";
    }
}

$checkEmail['email'] = $data['email'];

//validation gender
$data['gender'] = isset($DATA_OBJ->gender) ? $DATA_OBJ->gender : null;
if (empty($DATA_OBJ->gender)) {
    $error .= "Please, choose your gender.. <br>";
} else {
    if ($DATA_OBJ->gender != "male" && $DATA_OBJ->gender != "female") {
        $error .= "Please, choose valid gender.. male or female only.. <br>";
    }
}

//validation password
$data['password'] = $DATA_OBJ->password;
$password2 = $DATA_OBJ->password2;
if (empty($DATA_OBJ->password)) {
    $error .= "Please, enter a password. <br>";
} else {
    if ($DATA_OBJ->password != $DATA_OBJ->password2) {
        $error .= "Passwords not match. <br>";
    }
    if (strlen($DATA_OBJ->password) < 8) {
        $error .= "Password must be at least 8 characters. <br>";
    }
}

if ($error == "") {
    $query = "UPDATE users 
        SET username = :username, email =:email, gender = :gender, password = :password
        WHERE user_id = :user_id LIMIT 1";

    $result = $DB->write($query, $data);

    if ($result) {
        $info->message = "Your data was updated.";
        $info->data_type = "info";
        echo json_encode($info);
    } else {
        $info->message = "Your profile was NOT updated. Error.";
        $info->data_type = "error";
        echo json_encode($info);
    }
} else {
    $info->message = $error;
    $info->data_type = "error";
    echo json_encode($info);
}
