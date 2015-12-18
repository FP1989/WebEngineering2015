<!doctype html>
<html lang="de">
<head>
    <?php
    $pagetitle = "Reisen";
    include("includes/header.inc.php");
    ?>

    <script type = text/javascript>

        function deleteReiseID(button){

            var id = button.id;

            $('#deletepositive').hide();
            $('#deletenegative').hide();

            $("#loeschen").html("<button id= "+id +" class=\"btn btn-danger btn-md\" onclick=\"loeschen(this)\">L&ouml;schen</button><button class=\"btn btn-success btn-md pull-right\" data-dismiss=\"modal\">Abbrechen</button>");

        }

        function loeschen(button){

            var id = button.id;
            $.ajax({

                url:"reise.delete.php",
                type:"POST",
                dataType: "json",
                data:{

                    ReiseID_L: id
                },

                success: function(data){

                    if(data.flag){

                        $('#deletepositive').show().html(data.message).delay(500).fadeOut();
                        $('#deleteegative').hide(); //Wenn zuvor die Eingaben nicht vollständig waren/nicht richtig

                        //Nach einer positven Rückmeldung schliesst das Modal nach 1 Sekunde
                        $( "#deletepositive" ).promise().done(function() {
                            setTimeout(function(){
                                $('#Reiseloeschen').modal('hide');});
                        });
                    }

                    else {

                        $('#deletenegative').show().html(data.message);
                        $('#Reiseloeschen').effect( "shake", {times:2}, 500 );

                    }
                }
            });
        }

        function getReiseID(button) {

            var id = button.id;

            $.ajax({

                url: 'reisen.read.php',
                type: "POST",
                dataType: 'json',
                data: {
                    ReiseID_R: id
                },

                success: function (data) {

                    alert("success reisen");

                    document.getElementById("ReiseID_R").value = id;
                    document.getElementById("Ziel_R").value = data.Ziel_R;
                    document.getElementById("Beschreibung_R").value = data.Beschreibung_R;
                    document.getElementById("Bezeichnung_R").value = data.Bezeichnung_R;
                    document.getElementById("Preis_R").value = data.Preis_R;
                    document.getElementById("Hinreise_R").value = data.Hinreise_R;
                    document.getElementById("Rueckreise_R").value = data.Rueckreise_R;
                    document.getElementById("Maximalanzahl_R").value = data.Maximalanzahl_R;
                    document.getElementById("Mindestanzahl_R").value = data.Mindestanzahl_R;

                }

            });
        }
    </script>

    <script id="source" language="javascript" type="text/javascript">

        $(function(){

            $('#positive').hide();
            $('#negative').hide();
            $('#deletepositive').hide();
            $('#deletenegative').hide();

        });

    </script>

</head>
<body>
<div id="wrapper">
    <?php
    include_once("includes/navigation.inc.php");
    include_once("classes/database.class.php");
    include_once("reisen.modal.php");
    ?>

    <div id="content" class="container">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#createTravel">Neue Reise erfassen</a></li>
            <li><a data-toggle="tab" href="#editTravel">Reise ansehen / editieren</a></li>
        </ul>

        <div class="tab-content">
            <div id="createTravel" class="tab-pane fade in active">
                <?php include_once("reisen.write.php");?>
            </div> <!-- end tab-1 -->

            <div id="editTravel" class="tab-pane fade">
                <h2>Reise ansehen / Reise editieren</h2> <br/><br/>

                <h3>Reise ausw&auml;hlen</h3>
                <table id="Reise_mutieren" class='table table-striped'>
                   <?php
                   /** @var database $verbindung */
                    $verbindung = database::getDatabase();
                    $result = $verbindung->getAllReisen(0);

                    if($result->num_rows > 0) {

                        echo "<tr><th>Reise-ID</th><th>Reiseziel</th><th>Bezeichnung</th><th>Preis</th><th>Abreise</th><th>R&uuml;ckreise</th><th colspan=2></th></tr>";

                        while ($row = $result->fetch_assoc()) {

                            echo "<tr>";

                            foreach($row as $value){

                                if (preg_match('/[0-9]+[-]+/', $value)) {
                                    $date = date("d.m.Y", strtotime($value));
                                    echo "<td>" . $date . "</td>";
                                } else echo "<td>".$value."</td>";
                            }

                            echo "<td align=\"right\"><button id=\"".$row["ReiseID"]."\" onclick = \"getReiseID(this)\" class=\"btn btn-success btn-sm\" data-toggle = \"modal\" data-target = \"#Mutationsformular\" > mutieren</button><td ><button id = \"".$row["ReiseID"]."\" onclick = \"deleteReiseID(this)\" class=\"btn btn-danger btn-sm\" data-toggle = \"modal\" data-target = \"#Reiseloeschen\"> löschen</button ></td>";

                            echo "</tr>";
                        }
                    }

                    else echo "<tr><th>Keine Reisen erfasst</th></tr>";
                    ?>

                </table>

                <div class ="modal fade" id="Reiseloeschen" tabindex="-1" role="dialog">

                    <div class="modal-dialog modal-sm" role="document">

                        <div class="modal-content">

                            <div class="modal-header">
                                <h2>Sind Sie sicher?</h2>
                            </div>

                            <div class="modal-body">

                                <p class="alert alert-success" role="alert" id="deletepositive"></p>
                                <p class="alert alert-warning" role="alert" id="deletenegative"></p>

                                <div id="loeschen" class = "form-group"></div>
                            </div>
                        </div>
                    </div>
                </div>


            </div> <!-- end tab-2 -->
        </div> <!-- end tabs -->
    </div> <!-- end content div -->



    <script type="text/javascript">

        $(function() {
            $( "#hinreise" ).datepicker({
                onClose: function( selectedDate ) {
                    $( "#rueckreise" ).datepicker( "option", "minDate", selectedDate );
                }
            });
            $( "#rueckreise" ).datepicker({
                onClose: function( selectedDate ) {
                    $( "#hinreise" ).datepicker( "option", "maxDate", selectedDate );
                }
            });

            $.datepicker.setDefaults($.datepicker.regional["de"]);
        });


    </script>

<?php
include("includes/footer.inc.php");