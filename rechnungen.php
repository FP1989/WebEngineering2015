<!doctype html>
<html lang="de">
<head>
    <?php
    $pagetitle = "Rechnungen";
    include_once("includes/header.inc.php");
    ?>
    <script id="source" language="javascript" type="text/javascript">

        $(document).ready(function (){

            $.ajax({
                url: 'reisen.read.php', //   Skript, das aufgerufen wird

                data: "", //   Übergebene Daten
                dataType: 'json', //   Datenformat JSON
                success: function (data) { //   Erhalt des Ergebnisses => mehrere Datensätze

                    for (i = 0; i < data.length; i++) {

                        $('#reise').append("<option value= \""+ data[i].ReiseID +"\">ReiseID: "+ data[i].ReiseID +", Reiseziel: " + data[i].Ziel+ ", Abreise: "+ data[i].Hinreise+ "</option>");

                    }
                }
            });

            var reiseID;

            $("#reise").change(function(){

                reiseID =  $("#reise option:selected").val();

                $.ajax({

                    url: 'rechnungen.read.php',
                    type: "POST",
                    dataType: 'json',
                    data:{
                        ReiseID_R:  $("#reise option:selected").val(),
                    },

                    success: function (data) { //   Erhalt des Ergebnisses => mehrere Datensätze

                        var string;

                        for (i = 0; i < data.length; i++) {

                            string += "<option value= \""+ data[i].RechnungsID +"\">RechnungsID: "+ data[i].RechnungsID +", Betrag: " + data[i].Betrag + ", Fälligkeit: "+ data[i].Faelligkeit + "</option>";

                        }

                        $('#rechnung').html(string);

                    }
                });
            });

        });
        $("#suchen").click(function() {

            var rechnungsID =  $("#rechnung option:selected").val();

            alert "jejkwloe";

            $('#Mutationsformular').load("rechnungen.mutieren.php")

            $.ajax({

                url: 'rechnungen.read.php',
                type: "POST",
                data:{
                    RechnungsID_R:  $("#rechnung option:selected").val(),
                },
            }
        }

    </script>

</head>
<body>
<div id="wrapper">
<?php
include_once("includes/navigation.inc.php");
include_once("beguenstigter_modal.php");
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
                            <option>--w&auml;hlen Sie eine Reise aus--</option>
                        </select>

                    </div>

                    <div class = "form-group">
                        <label for="rechnung">Rechnung ausw&auml;hlen</label>
                        <select name="rechnung" id="rechnung" class ="form-control">
                            <option>--w&auml;hlen Sie eine Rechnung aus--</option>
                        </select>

                    </div>
                </form>
                <form action="rechnungen.mutieren.php">

                    <button type="submit" id="suchen" class="btn btn-primary">Reise erfassen</button>
                    <div id="Mutationsformular">


                    </div>
                </form>
            </div>  <!-- end tab-2 -->
        </div> <!-- end tabs -->
    </div> <!-- end content div -->


<?php
include("includes/footer.inc.php");