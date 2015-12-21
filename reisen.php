<?php include("includes/authentication.inc.php");?>
    <!doctype html>
    <html lang="de">
    <head>
        <?php
        $pagetitle = "Reisen";
        include("includes/header.inc.php");
        ?>

        <script type = text/javascript>

            $(function(){

                $('#positive').hide();
                $('#negative').hide();
                $('#deletepositive').hide();
                $('#deletenegative').hide();

                var zeitspanne = document.querySelector('input[name="zeitraum_reise"]:checked').value;

                $.ajax({

                    url: 'reisen.read.php',
                    type: "POST",
                    data: {

                        timespan: zeitspanne
                    },
                    dataType: 'json',
                    success: function (data) {

                        if(data[0] != null) {

                            var reisen = "<tr><th>Reise-ID</th><th>Reiseziel</th><th>Bezeichnung</th><th>Preis</th><th>Hinreise</th><th>Rückreise</th><th colspan=2></th></tr>";

                            for (var i = 0; i < data.length; i++) {

                                reisen += "<tr><td>" + data[i].ReiseID + "</td><td>" + data[i].Ziel + "</td><td>" + data[i].Bezeichnung + "</td><td>" + data[i].Preis + "</td><td>" + data[i].Hinreise + "</td><td>" + data[i].Rueckreise + "</td><td align=\"right\"><button id=\"" + data[i].ReiseID + "\" onclick = \"getReiseID(this)\" class=\"btn btn-success btn-sm\" data-toggle = \"modal\" data-target = \"#Mutationsformular\" > mutieren</button><td ><button id = \"" + data[i].ReiseID + "\" onclick = \"deleteReiseID(this)\" class=\"btn btn-danger btn-sm\" data-toggle = \"modal\" data-target = \"#Reiseloeschen\"> löschen</button ></td></tr>";
                            }
                        }

                        else reisen = "<tr><td>Keine Reisen erfasst</td></tr>";

                        $('#Reise_mutieren').html(reisen);

                    }
                });

                $("input[name=zeitraum_reise]:radio").change(function () {

                    var zeitspanne = document.querySelector('input[name="zeitraum_reise"]:checked').value;

                    $.ajax({

                        url: 'reisen.read.php',
                        type: "POST",
                        data: {

                            timespan: zeitspanne
                        },
                        dataType: 'json',
                        success: function (data) {

                            if(data[0] != null) {

                                var reisen = "<tr><th>Reise-ID</th><th>Reiseziel</th><th>Bezeichnung</th><th>Preis</th><th>Hinreise</th><th>Rückreise</th><th colspan=2></th></tr>";

                                for (var i = 0; i < data.length; i++) {

                                    reisen += "<tr><td>" + data[i].ReiseID + "</td><td>" + data[i].Ziel + "</td><td>" + data[i].Bezeichnung + "</td><td>" + data[i].Preis + "</td><td>" + data[i].Hinreise + "</td><td>" + data[i].Rueckreise + "</td><td align=\"right\"><button id=\"" + data[i].ReiseID + "\" onclick = \"getReiseID(this)\" class=\"btn btn-success btn-sm\" data-toggle = \"modal\" data-target = \"#Mutationsformular\" > mutieren</button><td ><button id = \"" + data[i].ReiseID + "\" onclick = \"deleteReiseID(this)\" class=\"btn btn-danger btn-sm\" data-toggle = \"modal\" data-target = \"#Reiseloeschen\"> löschen</button ></td></tr>";

                                }
                            }

                            else reisen = "<tr><td>Keine Reisen erfasst</td></tr>";

                            $('#Reise_mutieren').html(reisen);
                        }
                    });
                });
            });

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

                <br/>

                <input type="radio" value=0 name="zeitraum_reise" checked="checked"> aktuell &nbsp; &nbsp; &nbsp;
                <input type="radio" value=30 name="zeitraum_reise"> 30 Tage zurück &nbsp; &nbsp; &nbsp;
                <input type="radio" value=90 name="zeitraum_reise"> 90 Tage zurück &nbsp; &nbsp; &nbsp;
                <input type="radio" value=180 name="zeitraum_reise"> 180 Tage zurück &nbsp; &nbsp; &nbsp;
                <input type="radio" value=all name="zeitraum_reise"> alle Reisen

                <br/><br/>

                <table id="Reise_mutieren" class='table table-striped'>
                    <?php
                   /* /** @var database $verbindung *//*
                    $verbindung = database::getDatabase();
                    $result = $verbindung->getAllReisen(0);

                    if($result->num_rows > 0) {

                        echo "<tr><th>Reise-ID</th><th>Reiseziel</th><th>Bezeichnung</th><th>Preis</th><th>Abreise</th><th>Rückreise</th><th colspan=2></th></tr>";

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

                    else echo "<tr><th>Keine Reisen erfasst</th></tr>";*/
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
                numberOfMonths: 3,
                onClose: function( selectedDate ) {
                    $( "#rueckreise" ).datepicker( "option", "minDate", selectedDate );
                }
            });
            $( "#rueckreise" ).datepicker({
                numberOfMonths: 3,
                onClose: function( selectedDate ) {
                    $( "#hinreise" ).datepicker( "option", "maxDate", selectedDate );
                }
            });
            $( "#Hinreise_R" ).datepicker({
                onClose: function( selectedDate ) {
                    $( "#Rueckreise_R" ).datepicker( "option", "minDate", selectedDate );
                }
            });
            $( "#Rueckreise_R" ).datepicker({
                onClose: function( selectedDate ) {
                    $( "#Hinreise_R" ).datepicker( "option", "maxDate", selectedDate );
                }
            });

            $.datepicker.setDefaults($.datepicker.regional["de"]);
        });


    </script>

<?php
include("includes/footer.inc.php");