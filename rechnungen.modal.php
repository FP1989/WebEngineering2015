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
                            <input type="text" class="form-control" id="Beguenstigter_R" name="recipient" value=""/>
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

                    <button type="submit" id="ButtonSpeichern" type="button" name="gesendet" class="btn btn-primary">&Auml;nderungen speichern</button>
                    <button type="reset" id="ButtonLoeschen" class="btn btn-primary">Aendderungen verwerfen</button>

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
            var rechnungsID = $("#RechnungsID_R").val();
            var rechnungsArt = $("input[name=paymentoption]:checked").val();
            var


            $.ajax({
                url:"process.php",
                type:"POST",
                dataType:"json",
                data:{type:"claim",Name:Name,Strasse:Strasse,Hausnummer:Hausnummer, PLZ:PLZ, Ort:Ort},

                ContentType:"application/json",
                success: function(response){
                    var status = response.flag;
                    if(status==true){
                        $('#feedback_positive').show().html(response.message).delay(2000).fadeOut();
                        $('#name').val("");
                        $('#strasse').val("");
                        $('#hausnummer').val("");
                        $('#plz').val("");
                        $('#ort').val("");
                        $('#feedback_negative').hide(); //Wenn zuvor die Eingaben nicht vollständig waren/nicht richtig
                    }else {
                        $('#feedback_negative').show().html(response.message);
                        $('#newRecipient').effect( "shake", {times:4}, 1000 );
                        var Name = $('#name').val();
                        var Strasse = $('#strasse').val();
                        var Hausnummer = $('#hausnummer').val();
                        var PLZ = $('#plz').val();
                        var Ort = $('#ort').val();
                    }
                },
                error: function(err){
                    alert(JSON.stringify(err));
                }
            })
        });

    });

</script>