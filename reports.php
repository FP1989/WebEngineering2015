<?php
session_start();
$_SESSION = array();
?>
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
            <select name="report_type" id="select1" class="form-control input-small">
                <option value="kreditoren">Offene Rechnungen anzeigen</option>
                <option value="reiseteilnehmer">Kunden pro Reise</option>
                <option value="offene_rechnungen">Kunden mit offenen Rechnungen anzeigen</option>
                <option value="alle_kunden">Alle Kunden anzeigen</option>
                <option value="alle_reisen">Alle Reisen anzeigen</option>
                <option value="ausstehende_reisen">Ausstehende Reisen anzeigen</option>
                <option value="finanzuebersicht">Finanz&uuml;bersicht anzeigen</option>
                <option value="reisegruppe">Reisegruppen anzeigen</option>
            </select><br>
            <input type="submit" name="submit" class="btn btn-primary" value="Report generieren"/>
            <input type="submit" name="pdfbutton" class="btn btn-primary" value="Report als PDF generieren"/>
        </form>
    </div>
</div>
</body>
</html>

<?php
require "db_connect.php";

if(isset($_POST['pdfbutton'])) {
    $_SESSION['uniquery'] = $_POST['report_type'];
    header("Location:reports_pdf.php");
}

if (isset($_POST['report_type'], $_POST['submit'])) {
    $_SESSION['uniquery'] = $_POST['report_type'];
    $query = "SELECT * FROM Teilnehmer WHERE Hausnummer=6666";

    require("reports_query.php");
}
