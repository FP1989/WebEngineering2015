<!doctype html>
<html lang="de">
<head>
    <?php
    $pagetitle = "Rechnungen";
    include_once("includes/header.inc.php");
    ?>

    <script type="text/javascript">

        $(function (){

            $('#alterpositive').hide();
            $('#alternegative').hide();
            $("#deletenegative").hide();
            $("#deletepositive").hide();

            var zeitspanne = document.querySelector('input[name="zeitraum"]:checked').value;


            $.ajax({

                url: 'reisen.read.php',
                type: "POST",
                data: {

                    timespan: zeitspanne
                },
                dataType: 'json',
                success: function (data) {

                    var reisen = "<option>--w&auml;hlen Sie eine Reise aus--</option>";

                    for (var i = 0; i < data.length; i++) {

                        reisen += "<option value= \"" + data[i].ReiseID + "\">Reise-ID: " + data[i].ReiseID + ", Reiseziel: " + data[i].Ziel + ", Abreise: " + data[i].Hinreise + "</option>";

                    }

                    $('#reise').html(reisen);

                }
            });

            $("input[name=zeitraum]:radio").change(function () {

                var zeitspanne = document.querySelector('input[name="zeitraum"]:checked').value;

                $.ajax({

                    url: 'reisen.read.php',
                    type: "POST",
                    data: {

                        timespan: zeitspanne
                    },
                    dataType: 'json',
                    success: function (data) {

                        var reisen = "<option>--w&auml;hlen Sie eine Reise aus--</option>";

                        for (var i = 0; i < data.length; i++) {

                            reisen += "<option value= \"" + data[i].ReiseID + "\">Reise-ID: " + data[i].ReiseID + ", Reiseziel: " + data[i].Ziel + ", Abreise: " + data[i].Hinreise + "</option>";

                        }

                        $('#reise').html(reisen);
                    }
                });
            });

            $("#reise").change(function(){


                $.ajax({

                    url: 'rechnungen.read.php',
                    type: "POST",
                    dataType: 'json',
                    data:{
                        ReiseID_R:  $("#reise option:selected").val()
                    },

                    success: function (data) {

                        var string = '';

                        if(data[0].RechnungsID != null) {

                            string = "<h3>Rechnung ausw&auml;hlen</h3><tr><th>RechnungsID</th><th>Beg&uuml;nstigter</th><th>Betrag</th><th>F&auml;lligkeit</th><th>Bezahlt</th><th colspan=2></th></tr>";

                            for (var i = 0; i < data.length; i++) {

                                var bezstatus;

                                if(data[i].bezahlt ==1) bezstatus="Ja";
                                else bezstatus="Nein";

                                string += "<tr><td>" + data[i].RechnungsID + "</td><td>" + data[i].Beguenstigter + "</td><td>" + data[i].Betrag + "</td><td>" + data[i].Faelligkeit + "</td><td>"+bezstatus+"</td><td align=\"right\"><button id=" + data[i].RechnungsID + " onclick=\"getRechnungsID(this)\" class=\"btn btn-success btn-sm\" data-toggle=\"modal\" data-target=\"#Mutationsformular\">mutieren</button><td><button id=" + data[i].RechnungsID + " onclick=\"deleteRechnungsID(this)\" class=\"btn btn-danger btn-sm\" data-toggle=\"modal\" data-target=\"#Rechnungloeschen\" >löschen</button></td></tr>";

                            }
                        }

                        else string = "<tr><th>Leider wurden keine entsprechenden Rechnungen gefunden</th></tr>";

                        $('#rechnung').html(string);

                    }
                });
            });
        });



        function deleteRechnungsID(button){

            var id = button.id;

            $("#loeschen").html("<button id= "+id +" class=\"btn btn-danger btn-md\" onclick=\"loeschen(this)\">L&ouml;schen</button><button class=\"btn btn-success btn-md pull-right\" data-dismiss=\"modal\">Abbrechen</button>");

        }

        function loeschen(button){

            var id = button.id;
            $.ajax({

                url:"rechnungen.delete.php",
                type:"POST",
                dataType: "json",
                data:{

                    RechnungsID_L: id
                },

                success: function(data){

                    if(data.flag){

                        $('#deletepositive').show().html(data.message).delay(500).fadeOut();
                        $('#deleteegative').hide(); //Wenn zuvor die Eingaben nicht vollständig waren/nicht richtig

                        //Nach einer positven Rückmeldung schliesst das Modal nach 1 Sekunde
                        $( "#deletepositive" ).promise().done(function() {

                            setTimeout(function(){
                                $('#Rechnungloeschen').modal('hide');});
                        });


                    }

                    else {

                        $('#deletenegative').show().html(data.message);
                        $('#Rechnungloeschen').effect( "shake", {times:2}, 500 );

                    }
                }
            });
        }

        function getRechnungsID(button){

            var id = button.id;


            $.ajax({

                url: 'rechnungen.read.php',
                type: "POST",
                dataType: 'json',
                data:{
                    RechnungsID_R: id
                },

                success: function (data) {

                    document.getElementById("RechnungsID_R").value = id;
                    document.getElementById("Betrag_R").value = data.Betrag_R;
                    document.getElementById("IBAN_R").value = data.IBAN_R;
                    document.getElementById("Swift_R").value = data.SWIFT_R;
                    document.getElementById("Faelligkeit_R").value = data.Faelligkeit_R;
                    document.getElementById("Beguenstigter_R").value = data.Beguenstigter_R;
                    document.getElementById("Bemerkung_R").value = data.Bemerkung_R;
                    document.getElementById("Reise_R").value = data.Reise_R;


                    var waehrung = document.getElementById("Waehrung_R");
                    waehrung.value = data.Waehrung_R;

                    var kostenart = document.getElementById("Kostenart_R");
                    kostenart.value = data.Kostenart_R;

                    if(data.Rechnungsart_R=="ESR") document.getElementById("RA_ESR").checked = true;
                    else if (data.Rechnungsart_R=="RoterES") document.getElementById("RA_RES").checked = true;
                    else if (data.Rechnungsart_R=="Ausland") document.getElementById("RA_A").checked = true;

                    if(data.bezahlt_R == 0) document.getElementById("bez_n").checked = true;
                    else if(data.bezahlt_R == 1) document.getElementById("bez_y").checked = true;


                }
            });
        }

    </script>

</head>
<body>
<div id="wrapper">
<?php
include_once("includes/navigation.inc.php");
include_once("rechnungen.modal.php");
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
                <h2>Rechnung ansehen / Rechnung editieren</h2>

                <h3>Reise ausw&auml;hlen</h3>
                <select name="reise" id="reise" class="form-control"></select>

                <br/>

                <input type="radio" value=0 name="zeitraum" checked="checked"> aktuell &nbsp; &nbsp; &nbsp;
                <input type="radio" value=30 name="zeitraum"> 30 Tage zur&uuml;ck &nbsp; &nbsp; &nbsp;
                <input type="radio" value=90 name="zeitraum"> 90 Tage zur&uuml;ck &nbsp; &nbsp; &nbsp;
                <input type="radio" value=180 name="zeitraum"> 180 Tage zur&uuml;ck &nbsp; &nbsp; &nbsp;
                <input type="radio" value=all name="zeitraum"> alle Reisen

                <br/>

                <table name="rechnung" id="rechnung" class='table table-striped'></table>

                <div class ="modal fade" id="Rechnungloeschen" tabindex="-1" role="dialog">

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
            </div>  <!-- end tab-2 -->
        </div> <!-- end tabs -->
    </div> <!-- end content div -->


<?php
include("includes/footer.inc.php");