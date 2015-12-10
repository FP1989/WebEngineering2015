<!doctype html>
<html lang="de">
<head>
    <?php
    $pagetitle = "Rechnungen";
    include_once("includes/header.inc.php");
    ?>
    <script type = text/javascript>


        function deleteRechnungsID(button){

            var id = button.id;

            var div = document.getElementById("loeschen");

            div.innerHTML("<button id= "+id+"class=\"btn btn-danger btn-sm\" onclick=\"loeschen(this)\" >Loeschen</button>");

        }

        function loeschen(button){

            var id = button.id;
            //JQuery Befehl zum löschen

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

    <script id="source" language="javascript" type="text/javascript">

        $(function (){

            $('#positive').hide();
            $('#negative').hide();

            $.ajax({

                url: 'reisen.read.php',
                data: "",
                dataType: 'json',
                success: function (data) {

                    for (var i = 0; i < data.length; i++) {

                        $('#reise').append("<option value= \""+ data[i].ReiseID +"\">Reise-ID: "+ data[i].ReiseID +", Reiseziel: " + data[i].Ziel+ ", Abreise: "+ data[i].Hinreise+ "</option>");

                    }
                }
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

                        var string = "<h3>Rechnung ausw&auml;hlen</h3><tr><th>RechnungsID</th><th>Beg&uuml;nstigter</th><th>Betrag</th><th colspan=3>F&auml;lligkeit</th></tr>";

                        for (var i = 0; i < data.length; i++) {

                            string += "<tr><td>"+data[i].RechnungsID+"</td><td>"+data[i].Beguenstigter+"</td><td>"+data[i].Betrag+"</td><td>"+data[i].Faelligkeit+"</td><td align=\"right\"><button id="+data[i].RechnungsID+" onclick=\"getRechnungsID(this)\" class=\"btn btn-success btn-sm\" data-toggle=\"modal\" data-target=\"#Mutationsformular\">mutieren</button><td><button class=\"btn btn-danger btn-sm\" data-toggle=\"modal\" data-target=\"#Rechnungloeschen\" >löschen</button></td></tr>";

                        }

                        $('#rechnung').html(string);

                    }
                });
            });



        });

    </script>

</head>
<body>
<div id="wrapper">
<?php
include_once("includes/navigation.inc.php");
include_once("beguenstigter_modal.php");
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
                <h2>Rechnung ansehen / Rechnung editieren</h2> <br/><br/>

                        <h3>Reise ausw&auml;hlen</h3>
                        <select name="reise" id="reise" class="form-control">
                            <option>--w&auml;hlen Sie eine Reise aus--</option>
                        </select>



                        <table name="rechnung" id="rechnung" class='table table-striped'>

                        </table>


                <div class ="modal fade" id="Rechnungloeschen" tabindex="-1" role="dialog">

                    <div class="modal-dialog" role="document">

                        <div class="modal-content">

                            <div class="modal-header">
                                <h2>Sind Sie sicher?</h2> </br></br>
                            </div>

                            <div id="loeschen" class ="modal-body">

                            </div>
                        </div>

            </div>  <!-- end tab-2 -->
        </div> <!-- end tabs -->
    </div> <!-- end content div -->


<?php
include("includes/footer.inc.php");