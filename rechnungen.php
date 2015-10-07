
<?php
    $pagetitle = "Rechnungen";
    include("includes/header.inc.php");
    include("includes/navigation.inc.php");
?>
<div id="content">
    <div class="container">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#createBill">Rechnung erfassen</a></li>
            <li><a data-toggle="tab" href="#editBill">Rechnung ansehen / editieren</a></li>
        </ul>
        <div class="tab-content">
            <div id="createBill" class="tab-pane fade in active">
                <div class="container">
                    <form role="form">
                        <h2>Rechnung erfassen</h2> </br></br>

                        <div class="form-group">
                            <label>Einzahlungsart</label> </br>
                            <label class="radio-inline"><input type="radio" name="optradio">ESR</label>
                            <label class="radio-inline"><input type="radio" name="optradio">Roter Einzahlungsschein</label>
                            <label class="radio-inline"><input type="radio" name="optradio">Auslandzahlung</label>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    <label>Betrag</label>
                                    <input type="number" class="form-control"/>
                                </div>
                                <div class="col-md-2">
                                    <label>W&auml;hrung</label>
                                    <select class="form-control">
                                        <option>CHF</option>
                                        <option>EUR</option>
                                        <option>GBP</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div>
                                <label>Beg&uuml;nstigter</label>
                                <input type="text" class="form-control"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div>
                                <label>Referenz Rechnungssteller (Rechnungsnummer)</label>
                                <input type="number" class="form-control"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div>
                                <label>Zahlungszweck</label>
                                <textarea class="form-control" rows="3"></textarea>
                            </div>
                        </div>


                        <div class="form-group">
                            <div>
                                <label>Kostenart</label>
                                <select class="form-control">
                                    <option>Hotel</option>
                                    <option>Administration/Buchungsgeb&uuml;hren</option>
                                    <option>Versicherung</option>
                                    <option>Treibstoff</option>
                                    <option>Andere Kosten</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Zahlungstermin</label>
                            <div class="input-group date">
                                <input type='text' class="form-control" id="datepicker"/>
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                            </div>
                        </div>

                        <div class="input-group">
                            <div>
                                <label>Zahlungsfrist</label>
                         <span class="input-group-btn">
                            <select class="form-control">
                                <option>Sofort</option>
                                <option>Innert 10 Tagen</option>
                                <option>Innert 30 Tagen</option>
                                <option>Innert 60 Tagen</option>
                            </select>
                         </span>
                         <span class="input-group-btn">
                             <input class="form-control" placeholder="Andere Frist">
                         </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Zahlungsstatus</label>
                            <select class="form-control">
                                <option>Bezahlt</option>
                                <option>Unbezahlt</option>
                            </select>
                        </div>



                        <div class="form-group">
                            <button type="submit" class="btn btn-default">Erfassen</button>
                            <button type="reset" class="btn btn-default">Felder l&ouml;schen</button>
                        </div>
                    </form>

                </div>
            </div>


            <div id="editBill" class="tab-pane fade">

                <div class="form-group">
                    <h2>Rechnung ansehen / Rechnung editieren</h2> <br/><br/>
                </div>
            </div>
        </div>
    </div> <!-- end of Container -->
</div> <!-- end of content div -->

<?php
    include("includes/footer.inc.php");
?>

    <script type="text/javascript">
        $(function() {
            $( "#datepicker" ).datepicker();
            dateFormat: "dd-mm-yyyy",
            $.datepicker.setDefaults($.datepicker.regional["de"]);
        });
    </script>
