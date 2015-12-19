<?php
include_once("classes/database.class.php");

/* @var database $database*/
$database = database::getDatabase();
$_GET['term'] = 'Hotel';

$term = trim(strip_tags($_GET['term']));
$result = $database->autosuggestBeguenstigter('Bier');

$informationen = array();

for($i = 0; $i < count($result); $i++) {

    $informationen[$i]["term"] = $result[$i]["BegName"];
    $informationen[$i]["value"] = $result[$i]["BegID"];
}

echo json_encode($informationen);