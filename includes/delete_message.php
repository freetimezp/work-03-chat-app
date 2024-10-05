<?php

$arr['rowId'] = "null";

if (isset($DATA_OBJ->find->rowId)) {
    $arr['rowId'] = $DATA_OBJ->find->rowId;
}


$query = "SELECT * FROM messages WHERE id = :rowId LIMIT 1";
$result = $DB->read($query, $arr);

if (is_array($result)) {
    $row = $result[0];

    if ($_SESSION['user_id'] == $row->sender) {
        $query = "UPDATE messages SET deleted_sender = 1 WHERE id = '$row->id' LIMIT 1";
        $DB->write($query);
    }

    if ($_SESSION['user_id'] == $row->receiver) {
        $query = "UPDATE messages SET deleted_receiver = 1 WHERE id = '$row->id' LIMIT 1";
        $DB->write($query);
    }
}
