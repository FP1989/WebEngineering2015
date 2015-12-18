<?php
include_once("classes/database.class.php");

/* @var database $database*/
$database = database::getDatabase();

$term = trim(strip_tags($_GET['term']));
$result = $database->autosuggestReise($term);

$informationen = array();

for($i = 0; $i < count($result); $i++) {

//    $informationen['label'] = $result[$i]['BegName'];
//    $informationen['value'] = $result[$i]['BegID'];
    array_push($informationen, array('label' => $result[$i]['ReiseBez'], 'value' => $result[$i]['ReiseID']));
}



echo json_encode($informationen);