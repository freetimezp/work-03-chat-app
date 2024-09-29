<?php

$mydata = '
<div style="text-align:center;">
    <div id="contact">
        <img src="assets/images/user-1.jpg" alt="profile">
        <br>
        <span>Username</span>
    </div>
    <div id="contact">
        <img src="assets/images/user-2.jpg" alt="profile">
        <br>
        <span>Username</span>
    </div>
    <div id="contact">
        <img src="assets/images/user-3.jpg" alt="profile">
        <br>
        <span>Username</span>
    </div>
</div>';

//$result = $result[0];
$info->message = $mydata;
$info->data_type = "contacts";
echo json_encode($info);

die;

$info->message = "no contacts were found...";
$info->data_type = "error";
echo json_encode($info);
