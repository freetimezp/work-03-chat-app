<?php

$arr['user_id'] = "null";

if (isset($DATA_OBJ->find->user_id)) {
    $arr['user_id'] = $DATA_OBJ->find->user_id;
}

$arr['sender'] = $_SESSION['user_id'];
$arr['receiver'] = $arr['user_id'];


$query = "SELECT * FROM messages 
WHERE (sender = :sender && receiver = :receiver) 
|| (sender = :receiver && receiver = :sender)";
$result = $DB->read($query, $arr);

if (is_array($result)) {
    foreach ($result as $row) {
        if ($_SESSION['user_id'] == $row->sender) {
            $query = "UPDATE messages SET deleted_sender = 1 WHERE id = '$row->id' LIMIT 1";
            $DB->write($query);
        }

        if ($_SESSION['user_id'] == $row->receiver) {
            $query = "UPDATE messages SET deleted_receiver = 1 WHERE id = '$row->id' LIMIT 1";
            $DB->write($query);
        }
    }
}
