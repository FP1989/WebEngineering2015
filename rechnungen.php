
<?php
$pagetitle = "Rechnungen";
include("includes/header.inc.php");
include("includes/navigation.inc.php");
include ("beguenstigter_modal.php");
?>

    <div id="content" class="container">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#createBill">Neue Rechnung erfassen</a></li>
            <li><a data-toggle="tab" href="#editBill">Rechnung ansehen / editieren</a></li>
        </ul>

        <div class="tab-content">
            <div id="createBill" class="tab-pane fade in active">
                <?php include("rechnungen.write.php"); ?>
            </div> <!-- end tab-1 -->
            <div id="editBill" class="tab-pane fade">
                <h2>Rechnung ansehen / Rechnung editieren</h2> <br/><br/>
                <form role="form" method="post" action="">
                    <div class = "form-group">
                        <label for="reise">Reise ausw&auml;hlen</label>
                        <select name="reise" id="reise" class="form-control">
                            <?php
                            /** @var database $database*/
                            $database = database::getDatabase();

                            $link = $database->getLink();
                            $query = 'SELECT * FROM reise';

                            $result = $link->query($query);

                            while($datensatz = $result->fetch_assoc()){
                                echo "<option value = \"".$datensatz["ReiseID"]."\">";
                                echo $datensatz["ReiseID"]." ".$datensatz["Ziel"]." "."Datum: ".$datensatz["Hinreise"]."</option>";
                            } ?>
                        </select>
                    </div>
                     <div class="form-group pull-right">
                        <button type="submit" type="button" name="Reisegesucht" class="btn btn-primary">Rechnung suchen</button>
                    </div><br/><br/>
                </form>
                <?php
                if(isset($_POST["Reisegesucht"])){

                $gesuchteReise = $_POST['reise'];
                    echo "<form role=\"form\" method=\"post\" action=\"rechnungen.read.php\">";
                    echo "<div class = \"form-group\">";
                    echo "<label for=\"reise\">Reise ausw&auml;hlen</label>";
                    echo "<select name=\"reise\" id=\"reise\" class=\"form-control\">";

                    $query = "SELECT RechnungsID, Betrag, Waehrung, Beguenstigter, Faelligkeit, Kostenart  FROM rechnung WHERE Reise = ?";

                    $stmt = $link->prepare($query);
                    $stmt->bind_param('i', $gesuchteReise);


                    $stmt->execute();

                    $stmt->bind_result($rgID, $rgBetrag, $rgWaehrung, $rgBeguenstigter, $rgFaelligkeit, $rgKostenart);
                    while($stmt->fetch()){

                        echo "<option value =\"".$rgID."\">".$rgID." ".$rgKostenart." ".$rgWaehrung." ".$rgBetrag." ".$rgBeguenstigter." ".$rgFaelligkeit."</option>";

                    };
                    $stmt->close();


                        echo  "</select>";
                        echo "</div>";

                   echo "</div>";
                echo "</form>";}    ?>


            </div>  <!-- end tab-2 -->
        </div> <!-- end tabs -->
    </div> <!-- end content div -->


<?php
include("includes/footer.inc.php");