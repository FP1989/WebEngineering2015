<?php
include("includes/authentication.inc.php");


$term = trim(strip_tags($_GET['term']));
$mysqlquery = "SELECT * FROM Reise WHERE Bezeichnung LIKE '%{$term}%'";
$resultat = mysqli_query($conn, $mysqlquery);


$informationen = array();
    while ($row = mysqli_fetch_assoc($resultat)){
        array_push($informationen, array('label' => $row['Bezeichnung'], 'value' => $row['ReiseID']));
    }
echo json_encode($informationen);
?>