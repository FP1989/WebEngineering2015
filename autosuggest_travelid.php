<?php
include_once("classes/database.class.php");

/* @var database $database*/
$database = database::getDatabase();
include("includes/authentication.inc.php");


$term = trim(strip_tags($_GET['term']));
$result = $database->autosuggestReise($term);

$informationen = array();

for($i = 0; $i < count($result); $i++) {
    array_push($informationen, array('label' => $result[$i]['ReiseBez'], 'value' => $result[$i]['ReiseID']));
}



echo json_encode($informationen);