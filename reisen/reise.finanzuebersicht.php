<?php
include("../classes/database.class.php");
include_once("../classes/reise.class.php");
include("../includes/authentication.inc.php");

/* @var database $database*/
$database = database::getDatabase();

$reiseID = $_POST["wert"];

$reise = $database->fetchReise($reiseID);

$rechnungen = $database->getAllRechnungen($reiseID);
$reservationen = $database->fetchReservation($reiseID);

$totalAusgaben = 0;
$totalEinnahmen = 0;
?>

<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        <title>Finanzübersicht</title>
    </head>
    <body>
    <table class='table table-striped'>
        <tr><td colspan ="4" align="center"><span style="font-size:x-large;font-weight:bolder;">Finanzübersicht für die Reise nach <?php echo $reise->getZiel() ?></span></td></tr>
        <tr><td><b>Ausgaben:</b></td><td colspan ="3"></td></tr>

        <?php foreach($rechnungen as $row){

            $beg =$database->fetchBeguenstigter($row["Beguenstigter"]);

            echo "<tr><td>".$beg->getBeguenstigterID()."</td><td>".$beg->getBeguenstigterName()."</td><td>".$row["Bemerkung"]."</td><td>".$row["Betrag"]."</td></tr>";
            $totalAusgaben = $totalAusgaben + $row["Betrag"];

        }?>
        <tr><td colspan="3" align="right"><span style="font-size:large;font-weight:bolder;">Total Ausgaben:</span></td><td><span style="font-size:large;font-weight:bolder;"><?php echo $totalAusgaben?></span></td></tr>

        <tr><td><b>Einnahmen:</b></td><td colspan ="3"></td></tr>

        <?php foreach($reservationen as $row){

            $user = $database->fetchTeilnehmer($row["TeilnehmerID"]);

            echo "<tr><td>".$user->getTeilnehmerID()."</td><td>".$user->getVorname()."</td><td>".$user->getNachname()."</td><td>".$reise->getPreis()."</td></tr>";
            $totalEinnahmen = $totalEinnahmen + $reise->getPreis();

        }?>
        <tr><td colspan="3" align="right"><span style="font-size:large;font-weight:bolder;">Total Einnahmen:</span></td><td><span style="font-size:large;font-weight:bolder;"><?php echo $totalEinnahmen ?></span></td></tr>

        <tr><td colspan = "3" align="right"><span style="font-size:large;font-weight:bolder;">Totaler Gewinn: </span></td><td><span style="font-size:large;font-weight:bolder;"><?php echo $totalEinnahmen -$totalAusgaben ?></span></td></tr>
    </table>
    </body>
</html>