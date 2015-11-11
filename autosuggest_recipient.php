<?php

include("config.php");
include("db_connect.php");

$term = trim(strip_tags($_GET['term']));
$mysqlquery = "SELECT * from beguenstigter where beguenstigter.BeguenstigterName like '%{$term}%'";
$resultat = mysqli_query($conn, $mysqlquery);

$informationen = array();
    while ($row = mysqli_fetch_assoc($resultat)){
        array_push($informationen, array('label' => $row['BeguenstigterName'], 'value' => $row['BeguenstigterID']));
    }

echo json_encode($informationen);
?>