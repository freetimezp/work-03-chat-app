<?php

$mydata = 'settings';

//$result = $result[0];
$info->message = $mydata;
$info->data_type = "settings";
echo json_encode($info);

die;

$info->message = "no contacts were found...";
$info->data_type = "error";
echo json_encode($info);
