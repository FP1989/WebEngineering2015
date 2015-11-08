
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
                                echo "<option value = \"".$datensatz["ReiseID"]."\">".$datensatz["ReiseID"]." ".$datensatz["Ziel"]." Datum: ".$datensatz["Hinreise"]."</option>";
                            }?>
                        </select>
                    </div>
                </form>
            </div>  <!-- end tab-2 -->
        </div> <!-- end tabs -->
    </div> <!-- end content div -->
    <script type="text/javascript">
        $(function() {
            $( "#datepicker" ).datepicker();
            dateFormat: "dd-mm-yyyy",
                $.datepicker.setDefaults($.datepicker.regional["de"]);
        });
    </script>
<?php
include("includes/footer.inc.php");