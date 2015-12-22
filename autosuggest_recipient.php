<?php
include_once("classes/database.class.php");
include("includes/authentication.inc.php");


/* @var database $database*/
$database = database::getDatabase();

$term = trim(strip_tags($_GET['term']));
$result = $database->autosuggestBeguenstigter($term);

$informationen = array();

for($i = 0; $i < count($result); $i++) {

//    $informationen['label'] = $result[$i]['BegName'];
//    $informationen['value'] = $result[$i]['BegID'];
    array_push($informationen, array('label' => $result[$i]['BegName'], 'value' => $result[$i]['BegID']));
}



echo json_encode($informationen);
