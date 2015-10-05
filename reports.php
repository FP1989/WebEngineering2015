<html>
<head>
    <meta charset="utf-8"/>
    <title>Reports</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/font-awesome.min.css">
    <script type="text/javascript" src="jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="bootstrap.min.js"></script>

    <style>
       
    </style>
</head>
<body>
<div class="container" style="margin-top: 50px">
    <div class="form-group">
        <form action="" method="post" role="form" id="report_form">
            <h3>Reports</h3>
            <label for="select1">Report ausw&auml;hlen:</label>
            <select name="report_type" id="select1" class="form-control input-small"><br>
                <option value="kreditoren">Offene Rechnungen anzeigen</option>
                <option value="reiseteilnehmer">Kunden pro Reise</option>
                <option value="offene_rechnungen">Kunden mit offenen Rechnungen anzeigen</option>
                <option value="alle_kunden">Alle Kunden anzeigen</option>
                <option value="alle_reisen">Alle Reisen anzeigen</option>
                <option value="ausstehende_reisen">Ausstehende Reisen anzeigen</option>
                <option value="finanzuebersicht">Finanz&uuml;bersicht anzeigen</option>
                <option value="reisegruppe">Reisegruppen anzeigen</option>
            </select><br>
            <input type="submit" class="btn btn-primary" value="Report generieren"/>
        </form>
    </div>
</div>
</body>
</html>

<?php
require "db_connect.php";

if (isset($_POST['report_type'])) {

    $report_type = $_POST['report_type'];
    $query = "SELECT * FROM Teilnehmer WHERE Hausnummer=666";

    switch ($report_type) {

        case "kreditoren":
            break;
        case "reiseteilnehmer":
            $query = "SELECT R.ReiseID, R.Ziel, R.Hinreise, T.Vorname, T.Nachname, O.PLZ, O.Ortname FROM Teilnehmer T JOIN Reservation Re ON T.TeilnehmerID=Re.TeilnehmerID JOIN Reise R ON Re.ReiseID=R.ReiseID JOIN Ort O ON T.Ort=O.PLZ";
            break;
        case "offene_rechnungen":
            $query = "SELECT T.Nachname, T.Vorname, R.Ziel, R.Hinreise FROM Teilnehmer T JOIN Reservation Re ON T.TeilnehmerID=Re.TeilnehmerID JOIN Reise R ON Re.ReiseID=R.ReiseID WHERE Re.bezahlt = 0";
            break;
        case "alle_kunden":
            $query = "SELECT T.TeilnehmerID, T.Vorname, T.Nachname, T.Strasse, T.Hausnummer, O.PLZ, O.Ortname, T.Telefon, T.Mail FROM Teilnehmer T JOIN Ort O ON T.Ort= O.PLZ";
            break;
        case "alle_reisen":
            $query = "SELECT R.ReiseID, R.Ziel, R.Beschreibung, R.Bezeichnung, R.Preis, R.Hinreise, R.Rueckreise FROM Reise R";
            break;
        case "ausstehende_reisen":
            $query = "SELECT R.Ziel, R.Hinreise, T.Nachname, T.Vorname FROM Reise R JOIN Reservation Re ON R.ReiseID=Re.ReiseID JOIN Teilnehmer T ON Re.TeilnehmerID=T.TeilnehmerID WHERE R.Hinreise > CURDATE()";
            break;
        case "finanzuebersicht":
            break;
        case "reisegruppe":
            break;
    }

    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        echo "<div class='container'><table class='table table-striped'><tr>";

        while ($finfo = $result->fetch_field()) {
            echo "<th align='left' style='font-size:medium'>" . $finfo->name . "</th>";
        }
        echo "</tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr style='font-size:small'>";
            foreach ($row as $value) {
                echo "<td>" . $value . "</td>";
            }
            echo "</tr>";
        }
        echo "</table></div>";
    } else echo "<div class='container'>Keine Daten vorhanden zu dieser Abfrage.</div>";
    mysqli_close($conn);
}