<!doctype html>
<html lang="de">
<head>
    <?php
    $pagetitle = "Rechnungen";
    include_once("includes/header.inc.php");
    ?>
    <script type = text/javascript>

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
                    document.getElementById("recipient").value = String(data.Beguenstigter_R);
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

            $.ajax({

                url: 'reisen.read.php',
                data: "",
                dataType: 'json',
                success: function (data) {

                    for (var i = 0; i < data.length; i++) {

                        $('#reise').append("<option value= \""+ data[i].ReiseID +"\">ReiseID: "+ data[i].ReiseID +", Reiseziel: " + data[i].Ziel+ ", Abreise: "+ data[i].Hinreise+ "</option>");

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

                            string += "<tr><td>"+data[i].RechnungsID+"</td><td>"+data[i].Beguenstigter+"</td><td>"+data[i].Betrag+"</td><td>"+data[i].Faelligkeit+"</td><td align=\"right\"><button id="+data[i].RechnungsID+" onclick=\"getRechnungsID(this)\" class=\"btn btn-success btn-sm\" data-toggle=\"modal\" data-target=\"#Mutationsformular\">mutieren</button><td><a class=\"btn btn-danger btn-sm\" >löschen</a></td></tr>";

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



                <div class ="modal fade" id="Mutationsformular" tabindex="-1" role="dialog">

                    <div class="modal-dialog" role="document">

                        <div class="modal-content">

                            <div class="modal-header">
                                <h2>Rechnung mutieren</h2> </br></br>
                            </div>

                            <div class ="modal-body">
                            <form role="form" method="post" action="">
                                <div class="form-group">
                                    <label>Rechnungs-ID</label>
                                    <input class="form-control" id="RechnungsID_R" type="text" readonly>
                                </div>

                                <div class="form-group">
                                    <label>Rechnungsart</label> </br>
                                    <label class="radio-inline"><input type="radio" name="paymentoption" id="RA_ESR" value="ESR">ESR</label>
                                    <label class="radio-inline"><input type="radio" name="paymentoption" id="RA_RES" value="RoterES">Roter Einzahlungsschein</label>
                                    <label class="radio-inline"><input type="radio" name="paymentoption" id="RA_A" value="Ausland">Auslandzahlung</label>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <label>Betrag</label>
                                            <input type="number" id="Betrag_R" name="amount" class="form-control"/>
                                        </div>
                                        <div class="col-md-4">
                                            <label>W&auml;hrung</label>
                                            <select id ="Waehrung_R" name="currency" class="form-control">
                                                <option value="CHF">CHF</option>
                                                <option value="EUR">EUR</option>
                                                <option value="GBP">GBP</option>
                                                <option value="USD">USD</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>IBAN</label>
                                    <input type="text" id="IBAN_R" name="iban" title="Format: CH63 4489 9857 4842 9034 6" class="form-control"/>
                                </div>
                                <div class="form-group">
                                    <label>Swift</label>
                                    <input type="text" id="Swift_R" name="swift" title="Format: LUKBCH2260A" class="form-control" value=""/>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <label>F&auml;lligkeit</label>
                                            <input type='text' id="Faelligkeit_R" class="form-control" name="duedate" title="Format [dd.mm.jjjj]"  id="datepicker" value=""/>

                                        </div>
                                        <div class="col-md-4">
                                            <label>Kostenart</label>
                                            <select id="Kostenart_R" name="costs" class="form-control">
                                                <option value="Hotel">Hotel</option>
                                                <option value="Administration">Administration</option>
                                                <option value="Versicherung">Versicherung</option>
                                                <option value="Treibstoff">Treibstoff</option>
                                                <option value="Sonstiges">Sonstiges</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Beg&uuml;nstigter</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="recipient" name="recipient" value=""/>
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#newRecipient">Neuen Beg&uuml;nstigten anlegen</button>
                                </span>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <div>
                                        <label>Bemerkung</label>
                                        <textarea id="Bemerkung_R" class="form-control" rows="3" name="comment"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Reise</label>
                                    <input id="Reise_R" class="form-control" type="text" id="travel" name="travelid" value=""/>
                                </div>
                                <div class="form-group">
                                    <label>Rechnung bezahlt?</label> </br>
                                    <label class="radio-inline"><input type="radio" id="bez_y" name="paidBill">Ja</label>
                                    <label class="radio-inline"><input type="radio" id="bez_n" name="paidBill">Nein</label>
                                </div>

                                    <button type="submit" type="button" name="gesendet" class="btn btn-primary">&Auml;nderungen speichern</button>
                                    <button type="reset" class="btn btn-primary">Rechnung l&ouml;schen</button>

                            </form>
                                </div>
                        </div>
                    </div>
                </div>

            </div>  <!-- end tab-2 -->
        </div> <!-- end tabs -->
    </div> <!-- end content div -->


<?php
include("includes/footer.inc.php");