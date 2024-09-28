<?php

if (isset($_SESSION['user_id'])) {
    unset($_SESSION['user_id']);
}

$info->logged_in = false;

echo json_encode($info);
