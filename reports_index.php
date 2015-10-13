<?php
session_start();
$_SESSION = array();

$pagetitle = "Reports";
include("includes/header.inc.php");
include("includes/navigation.inc.php");
?>
<div id="content">
    <div class="container">
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

<?php
require "db_connect.php";

if(isset($_POST['pdfbutton'])) {
    $_SESSION['uniquery'] = $_POST['report_type'];
    header("Location:reports_pdf.php");
}

if (isset($_POST['report_type'], $_POST['submit'])) {
    $_SESSION['uniquery'] = $_POST['report_type'];
    $query = "";

    require("reports_query.php");

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
?>
</div>