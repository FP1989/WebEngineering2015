<!doctype html>
<html lang="de">
<head>
    <?php
    $pagetitle = "Reservationen";
    include("includes/header.inc.php");
    ?>

    <script type = text/javascript>


        $(function () {

            $('#deletepositive').hide();
            $('#deletenegative').hide();
        });

        function setBezahlt(button){

            var id = button.id;

            $("#bestaetigen").html("<button id= "+id +" class=\"btn btn-danger btn-md\" onclick=\"setBezahltDB(this)\">Rechnung bezahlt</button><button class=\"btn btn-success btn-md pull-right\" data-dismiss=\"modal\">Abbrechen</button>");

        }

        function setBezahltDB(button){

            var reiseID = button.id;
            var teilnehmerID = document.getElementById("readonlyID").value;

            $.ajax({

                url:"reservationen.process.php",
                type:"POST",
                dataType: "json",
                data:{

                    ReiseID_L: reiseID,
                    TeilnehmerID_L: teilnehmerID
                },

                success: function(data){

                    if(data.flag){

                        $('#deletepositive').show().html(data.message).delay(1000).fadeOut();
                        $('#deletenegative').hide(); //Wenn zuvor die Eingaben nicht vollständig waren/nicht richtig

                        //Nach einer positven Rückmeldung schliesst das Modal nach 1 Sekunde
                        $( "#deletepositive" ).promise().done(function() {
                            setTimeout(function(){
                                $('#bestaetigung').modal('hide');});
                        });
                    }

                    else {

                        $('#deletenegative').show().html(data.message);
                        $('#Rechnungloeschen').effect( "shake", {times:2}, 500 );

                    }
                }
            });




        }

        function deleteReservationDB(button){

            var reiseID = button.id;
            var teilnehmerID = document.getElementById("readonlyID").value;

            $.ajax({

                url:"reservationen.delete.php",
                type:"POST",
                dataType: "json",
                data:{

                    ReiseID_L: reiseID,
                    TeilnehmerID_L: teilnehmerID
                },

                success: function(data){

                    if(data.flag){

                        $('#deletepositive').show().html(data.message).delay(2000).fadeOut();
                        $('#deleteegative').hide(); //Wenn zuvor die Eingaben nicht vollständig waren/nicht richtig

                        //Nach einer positven Rückmeldung schliesst das Modal nach 1 Sekunde
                        $( "#deletepositive" ).promise().done(function() {
                            setTimeout(function(){
                                $('#beschtaetigung').modal('hide');});
                        });
                    }

                    else {

                        $('#deletenegative').show().html(data.message);
                        $('#Rechnungloeschen').effect( "shake", {times:2}, 500 );

                    }
                }
            });
        }

        function deleteReservation(button){

            var id = button.id;

            $("#bestaetigen").html("<button id= "+id +" class=\"btn btn-danger btn-md\" onclick=\"deleteReservationDB(this)\">L&ouml;schen</button><button class=\"btn btn-success btn-md pull-right\" data-dismiss=\"modal\">Abbrechen</button>");

        }

        function showReservationen(teilnehmerID){

            $.ajax({

                url: 'reservationen.read.php',
                type: "POST",
                data: {

                    TeilnehmerID_R: teilnehmerID

                },
                dataType: 'json',
                success: function (data) {

                    var string = '';

                    if(data[0].TeilnehmerID != null && data[0].TeilnehmerID != '') {

                        string = "<tr><th>Reise-ID</th><th>Reiseziel</th><th>Abreise</th><th>bezahlt</th><th colspan=2></th></tr>";

                        for (var i = 0; i < data.length; i++) {

                            string+= "<tr><td>" + data[i].ReiseID + "</td><td>" + data[i].Ziel + "</td><td>" + data[i].Hinreise + "</td>";

                            if(data[i].bezahlt ==1) string += "<td>Ja</td><td align=\"right\"></td>";
                            else string += "<td>Nein</td><td align=\"right\"><button id=" + data[i].ReiseID + " onclick=\"setBezahlt(this)\" class=\"btn btn-success btn-sm\" data-toggle=\"modal\" data-target=\"#bestaetigung\">Rechnung bezahlt</button></td>"

                            string += "<td><button id= " + data[i].ReiseID + " onclick=\"deleteReservation(this)\" class=\"btn btn-danger btn-sm\" data-toggle=\"modal\" data-target=\"#bestaetigung\" >löschen</button></td></tr>";

                        }
                    }

                    else string = "<tr><th>Leider wurde keine entsprechende Reservation gefunden</th></tr>";

                    $('#Reservation_mutieren').html(string);

                }
            });


        }

        function searchTeilnehmer(){

            var user = document.getElementById("usr");
            var val = user.value;

            if (isNaN(val)) {

                user.style.backgroundColor = "white";


                $.ajax({

                    url: 'teilnehmer.read.php',
                    type: "POST",
                    dataType: 'json',
                    data: {
                        Nachname_R: val
                    },

                    success: function (data) {


                        if (data.TeilnehmerID_R != '' && data.TeilnehmerID_R != null) {

                            document.getElementById("readonlyID").value = data.TeilnehmerID_R;
                            document.getElementById("readonlyName").value = data.Nachname_R;
                            showReservationen(data.TeilnehmerID_R);

                        }

                        else document.getElementById("usr").style.backgroundColor = "red";
                    }
                });
            }

            else{

                user.style.backgroundColor = "white";

                $.ajax({

                    url: 'teilnehmer.read.php',
                    type: "POST",
                    dataType: 'json',
                    data: {
                        TeilnehmerID_R: val
                    },

                    success: function (data) {

                        if (data.TeilnehmerID_R != '' && data.TeilnehmerID_R != null){

                            document.getElementById("readonlyID").value = data.TeilnehmerID_R;
                            document.getElementById("readonlyName").value = data.Nachname_R;
                            showReservationen(data.TeilnehmerID_R);

                        }

                        else document.getElementById("usr").style.backgroundColor = "red";
                    }
                });

            }




        }

    </script>

    <script id="source" language="javascript" type="text/javascript">
    </script>

</head>
<body>
<div id="wrapper">
    <?php
    include_once("includes/navigation.inc.php");
    include_once("classes/database.class.php");
    ?>

    <div id="content" class="container">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#createReservation">Neue Reservation erfassen</a></li>
            <li><a data-toggle="tab" href="#editReservation">Reservationen ansehen / editieren</a></li>
        </ul>

        <div class="tab-content">
            <div id="createReservation" class="tab-pane fade in active">
                <?php include_once("reservationen.write.php");?>
            </div> <!-- end tab-1 -->

            <div id="editReservation" class="tab-pane fade">
                <h2>Reservationen ansehen / Reservationen editieren</h2> <br/><br/>

                <div class="form-group">
                    <label for="nr">Teilnehmer-Nr oder Teilnehmer-Nachname:</label>
                    <input type="text" class="form-control" id="usr">
                </div>

                <button onclick="searchTeilnehmer()" class="btn btn-success btn-md">Suchen</button><br/><br/>

                <div class="form-group">
                    <div class="row">
                        <div class ="col-md-4">
                            <label>Teilnehmer-ID</label>
                            <input id="readonlyID" class="form-control " name="id" type="text" readonly>
                        </div>
                        <div class="col-md-8">
                            <label>Teilnehmer-Nachname</label>
                            <input id="readonlyName" class="form-control" name="name" type="text" readonly>
                        </div>
                    </div>
                </div>

                <table id="Reservation_mutieren" class='table table-striped'></table>

                <div class ="modal fade" id="bestaetigung" tabindex="-1" role="dialog">

                    <div class="modal-dialog modal-sm" role="document">

                        <div class="modal-content">

                            <div class="modal-header">
                                <h2>Sind Sie sicher?</h2>
                            </div>

                            <div class="modal-body">

                                <p class="alert alert-success" role="alert" id="deletepositive"></p>
                                <p class="alert alert-warning" role="alert" id="deletenegative"></p>

                                <div id="bestaetigen" class = "form-group"></div>
                            </div>
                        </div>
                    </div>
                </div>


            </div> <!-- end tab-2 -->
        </div> <!-- end tabs -->
    </div> <!-- end content div -->

<?php
include("includes/footer.inc.php");