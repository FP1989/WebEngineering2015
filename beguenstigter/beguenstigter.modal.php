<?php include("../includes/authentication.inc.php"); ?>

<div class ="modal fade" id="Mutationsformular" tabindex="-1" role="dialog">

    <div class="modal-dialog" role="document">

        <div class="modal-content">

            <div class="modal-header">
                <h2>Begünstigter mutieren</h2> </br></br>
            </div>

            <div class ="modal-body">

                <form role="form" method="post" action="">
                    <p class="alert alert-success" role="alert" id="positive"></p>
                    <p class="alert alert-warning" role="alert" id="negative"></p>

                    <div class="form-group">
                        <label>Begüstigter-ID</label>
                        <input class="form-control" id="BeguenstigterID_R" type="text" readonly>
                    </div>

                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="Name" id="Name_R" class="form-control" />
                    </div>

                    <div class="form-group">
                        <div class="row">

                            <div class="col-md-8">
                                <label>Strasse</label>
                                <input type="text" name="Strasse" id="Strasse_R" class="form-control"/>
                            </div>

                            <div class="col-md-4">
                                <label>Hausnummer</label>
                                <input type="text" name="Hausnummer" id="Hausnummer_R" class="form-control"/>
                            </div>

                        </div>
                    </div>

                    <div class="form-group">

                        <div class="row">

                            <div class="col-md-8">
                                <label>PLZ</label>
                                <input type="number" name="PLZ" id="PLZ_R" class="form-control"/>
                            </div>

                            <div class="col-md-4">
                                <label>Ort</label>
                                <input type="text" name="Ort" id="Ort_R" class="form-control"/>
                            </div>

                        </div>

                    </div>

                    <div class="form-group">

                        <button type="submit" name ="gesendet" id="BeguenstigterSpeichern" class="btn btn-primary">Begünstigten mutieren</button> &nbsp;
                        <button type="reset" id="AenderungenVerwerfen" class="btn btn-primary" data-dismiss="modal">Abbrechen</button>
                        <div class="btn-group pull-right">
                            <button type="button" id="begloeschen" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Begünstigter löschen <span class="caret"></span></button>
                            <ul class="dropdown-menu">
                                <li><a href="javascript:deleteBeguenstigter()" id="BGloeschen">Klicken Sie hier um den Begünstigten definitiv zu löschen</a></li>
                            </ul>
                        </div>

                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script id="source" language="javascript" type="text/javascript">

    function deleteBeguenstigter(){

        var id = document.getElementById("BeguenstigterID_R").value;

        $.ajax({

            url:"beguenstigter.delete.php",
            type:"POST",
            dataType: "json",
            data:{

                BeguenstigterID_L: id
            },

            success: function(data){

                if(data.flag){

                    $('#positive').show().html(data.message).delay(750).fadeOut();
                    $('#negative').hide(); //Wenn zuvor die Eingaben nicht vollständig waren/nicht richtig

                    //Nach einer positven Rückmeldung schliesst das Modal nach 1 Sekunde
                    $("#positive").promise().done(function() {
                            $('#Mutationsformular').modal('hide');
                    });

                }

                else {

                    $('#negative').show().html(data.message);
                    $('#Mutationsformular').effect( "shake", {times:2}, 500 );
                }
            }
        });
    }

    $(function (){

        $("#BeguenstigterSpeichern").on("click", function(e){

            e.preventDefault();

            // get values from textboxs

            var begID = $("#BeguenstigterID_R").val();
            var name = $("#Name_R").val();
            var strasse = $("#Strasse_R").val();
            var hausnummer = $("#Hausnummer_R").val();
            var plz = $("#PLZ_R").val();
            var ort = $("#Ort_R").val();

            $.ajax({

                url:"beguenstigter.modal.process.php",
                type:"POST",
                dataType:"json",
                data:{

                    BeguenstigterID_R:begID,
                    Name:name,
                    Strasse:strasse,
                    Hausnummer:hausnummer,
                    PLZ:plz,
                    Ort:ort

                },

                success: function(response){

                    var status = response.flag;
                    if(status){

                        $('#positive').show().html(response.message).delay(1000).fadeOut();
                        $('#negative').hide(); //Wenn zuvor die Eingaben nicht vollständig waren/nicht richtig

                        //Nach einer positven Rückmeldung schliesst das Modal nach 1 Sekunde
                        $( "#positive" ).promise().done(function() {

                                $('#Mutationsformular').modal('hide');
                        });
                    }

                    else {

                        $('#negative').show().html(response.message);
                        $('#Mutationsformular').effect( "shake", {times:2}, 500 );
                    }
                }
            });
        });

        $("#Mutationsformular").on("hidden.bs.modal", function(e){

            $('#negative').hide();
            $('#positive').hide();

        });

    });

</script>