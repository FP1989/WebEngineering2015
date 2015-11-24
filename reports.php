<?php session_start();?>
<!doctype html>
<html lang="de">
<head>
    <?php
    $pagetitle = "Reports";
    include_once("includes/header.inc.php");
    ?>


</head>
<body>
<div id="wrapper">

<?php
include_once("includes/navigation.inc.php");
include_once("classes/database.class.php");

if(isset($_POST['pdfbutton'])) {
    $_SESSION['type'] = $_POST['type'];
    header("Location:print_pdf.php");
}
?>

    <div id="content" class="container">
        <div class="form-group">
            <form action="" method="post" role="form" id="report_form">
                <h2>Reports</h2>
                <div class="form-group">
                    <label for="select1">Report ausw&auml;hlen:</label>
                    <select name="type" id="select1" class="form-control">
                        <option value="Kreditoren" <?php echo (isset($_POST['type']) && $_POST['type'] == 'Kreditoren') ? "selected" : ""?>>Offene Rechnungen anzeigen</option>
                        <option value="Reiseteilnehmer" <?php echo (isset($_POST['type']) && $_POST['type'] == 'Reiseteilnehmer') ? "selected" : ""?>>Kunden pro Reise</option>
                        <option value="Debitoren" <?php echo (isset($_POST['type']) && $_POST['type'] == 'Debitoren') ? "selected" : ""?>>Kunden mit offenen Rechnungen anzeigen</option>
                        <option value="Kundenuebersicht" <?php echo (isset($_POST['type']) && $_POST['type'] == 'Kundenuebersicht') ? "selected" : ""?>>Alle Kunden anzeigen</option>
                        <option value="Reiseuebersicht" <?php echo (isset($_POST['type']) && $_POST['type'] == 'Reiseuebersicht') ? "selected" : ""?>>Alle Reisen anzeigen</option>
                        <option value="Reisen demnaechst" <?php echo (isset($_POST['type']) && $_POST['type'] == 'REisen demnaechst') ? "selected" : ""?>>Ausstehende Reisen anzeigen</option>
                        <option value="Finanzuebersicht" <?php echo (isset($_POST['type']) && $_POST['type'] == 'Finanzuebersicht') ? "selected" : ""?>>Finanz&uuml;bersicht anzeigen</option>
                        <option value="Reisegruppen" <?php echo (isset($_POST['type']) && $_POST['type'] == 'Reisegruppen') ? "selected" : ""?>>Reisegruppen anzeigen</option>
                    </select><br>
                </div>
                <div class="form-group pull-right">
                    <input type="submit" name="submit" class="btn btn-primary" value="Report generieren"/>
                    <input type="submit" name="pdfbutton" class="btn btn-primary" value="Report als PDF generieren"/>
                </div>
            </form>
        </div>
        <?php

        if (isset($_POST['type'], $_POST['submit'])) {

            /** @var database $verbindung */
            $verbindung = database::getDatabase();
            $result = $verbindung->generateReport($_POST['type']);

            if ($result->num_rows > 0) {

                echo "<table class='table table-striped'><tr>";

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
                echo "</table>";

            } else echo "<div class='container'>Keine Daten vorhanden zu dieser Abfrage.</div>";
        }
        ?>
    </div>
<?php
require ("includes/footer.inc.php");