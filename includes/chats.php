<?php

$mydata = 'chats';

//$result = $result[0];
$info->message = $mydata;
$info->data_type = "chats";
echo json_encode($info);

die;

$info->message = "no chats were found...";
$info->data_type = "error";
echo json_encode($info);
