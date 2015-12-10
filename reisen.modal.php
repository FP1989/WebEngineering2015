<div class ="modal fade" id="Mutationsformular" tabindex="-1" role="dialog">

    <div class="modal-dialog" role="document">

        <div class="modal-content">

            <div class="modal-header">
                <h2>Reise mutieren</h2> </br></br>
            </div>

            <div class ="modal-body">

                <form role="form" method="post" action="">
                    <div class="form-group">
                        <label>Reise-ID</label>
                        <input class="form-control" id="ReiseID_R" type="text" readonly>
                    </div>

                    <div class="form-group">
                        <label>Ziel</label>
                        <input class="form-control" name="destination" id="Ziel_R" type="text">
                    </div>

                    <div class="form-group">
                        <label>Beschreibung</label>
                        <textarea class="form-control" id="Beschreibung_R" name="description" rows="3"></textarea>
                    </div>

                    <div class="form-group">
                        <label>Bezeichnung</label>
                        <input class="form-control" name="travelname" id="Bezeichnung_R" type="text">
                    </div>

                    <div class="form-group">
                        <label>Preis</label>
                        <input class="form-control" type="number" name="price" id="Preis_R">
                    </div>

                    <div class="form-group">
                        <label>Hinreise</label>
                        <div class="input-group date">
                            <input type='text' class="form-control" name="fromdate" id="Hinreise_R"/>

                                        <span class="input-group-addon">
                                                     <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>R&uuml;ckreise</label>
                        <div class="input-group date">
                            <input type='text' class="form-control" name="todate" id="Rueckreise_R"/>

                                        <span class="input-group-addon">
                                                     <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" id="ButtonSpeichern" name="gesendet" class="btn btn-primary">&Auml;nderungen erfassen</button>
                        <button type="reset" class="btn btn-primary">Felder l&ouml;schen</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
    </div>


<script id="source" language="javascript" type="text/javascript">

    $(function (){



        $("#ButtonSpeichern").on("click", function(e){

            e.preventDefault();

            // get values from textboxs
            var reiseID = $("#ReiseID_R").val();
            var ziel = $("#Ziel_R").val();
            var beschreibung = $("#Beschreibung_R").val();
            var bezeichnung = $("#Bezeichnung_R").val();
            var preis = $("#Preis_R").val();
            var hinreise = $("#Hinreise_R").val();
            var rueckreise = $("#Rueckreise_R").val();

            $.ajax({
                url:"reisen.process.php",
                type:"POST",
                dataType:"json",
                data:{

                    ReiseID_P:reiseID,
                    Ziel_P:ziel,
                    Beschreibung_P:beschreibung,
                    Bezeichnung_P:bezeichnung,
                    Preis_P:preis,
                    Hinreise_P:hinreise,
                    Rueckreise_P:rueckreise

                },

                ContentType:"application/json",
                success: function(response){
                    var status = response.flag;
                    if(status){
                        $('#feedback_positive').show().html(response.message).delay(2000).fadeOut();

                        $('#feedback_negative').hide(); //Wenn zuvor die Eingaben nicht vollständig waren/nicht richtig

                        alert(response.message);

                    }

                    else {

                        $('#feedback_negative').show().html(response.message);
                        $('#Mutationsformular').effect( "shake", {times:4}, 1000 );

                    }
                },
                error: function(err){
                    alert(JSON.stringify(err));
                }
            });
        });

    });

</script>