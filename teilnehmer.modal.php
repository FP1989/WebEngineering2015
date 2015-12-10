<div class ="modal fade" id="Mutationsformular" tabindex="-1" role="dialog">

    <div class="modal-dialog" role="document">

        <div class="modal-content">

            <div class="modal-header">
                <h2>Teilnehmer mutieren</h2> </br></br>
            </div>

            <div class ="modal-body">

                <form role="form" method="post" action="">
                    <div class="form-group">
                        <label>Teilnehmer-ID</label>
                        <input class="form-control" id="TeilnehmerID_R" type="text" readonly>
                    </div>

                    <div class="form-group">
                        <label>Vorname</label>
                        <input class="form-control" id="Vorname_R" name="surname" type="text">
                    </div>

                    <div class="form-group">
                        <label>Nachname</label>
                        <input class="form-control" id="Nachname_R" name="lastname" type="text">
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-8">
                                <label>Strasse</label>
                                <input class="form-control" id="Strasse_R" name="street" type="text">
                            </div>
                            <div class="col-md-4">
                                <label>Hausnummer</label>
                                <input class="form-control" id="Hausnummer_R" name="housenumber" type="number">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label>PLZ</label>
                                <input class="form-control" id="PLZ_R" name="plz" type="text">
                            </div>
                            <div class="col-md-8">
                                <label>Ort</label>
                                <input class="form-control" id="Ort_R" name="town" type="text">
                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <label>Telefon Nr.</label>
                        <input class="form-control" id="Telefon_R" name="telefon" type="number">
                    </div>

                    <div class="form-group">
                        <label>E-Mail Adresse</label>
                        <input class="form-control" id="Mail_R" name="email" type="text">
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
            var teilnehmerID = $("#TeilnehmerID_R").val();
            var vorname = $("#Vorname_R").val();
            var nachname = $("#Nachname_R").val();
            var strasse = $("#Strasse_R").val();
            var hausnummer = $("#Hausnummer_R").val();
            var plz = $("#PLZ_R").val();
            var ort = $("#Ort_R").val();
            var telefon = $("#Telefon_R").val();
            var mail= $("#Mail_R").val();

            $.ajax({

                url:"teilnehmer.process.php",
                type:"POST",
                dataType:"json",
                data:{

                    TeilnehmerID_P:teilnehmerID,
                    Vorname_P:vorname,
                    Nachname_P:nachname,
                    Strasse_P:strasse,
                    Hausnummer_P:hausnummer,
                    PLZ_P:plz,
                    Ort_P:ort,
                    Telefon_P:telefon,
                    Mail_P:mail

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

                        alert(response.message);

                    }
                }
            });
        });

    });

</script>