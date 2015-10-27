
<?php
$pagetitle = "Rechnungen";
include("includes/header.inc.php");
include("includes/navigation.inc.php");
?>
<div id="content" class="container">
    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#createBill">Rechnung erfassen</a></li>
        <li><a data-toggle="tab" href="#editBill">Rechnung ansehen / editieren</a></li>
    </ul>

    <div class="tab-content">
        <div id="createBill" class="tab-pane fade in active">
            <h2>Rechnung erfassen</h2> </br></br>

            <div class="form-group">
                <label>Rechnungs-ID</label>
                <input class="form-control" type="text" readonly>
            </div>


            <div class="form-group">
                <label>Einzahlungsart</label> </br>
                <label class="radio-inline"><input type="radio" name="optradio">ESR</label>
                <label class="radio-inline"><input type="radio" name="optradio">Roter Einzahlungsschein</label>
                <label class="radio-inline"><input type="radio" name="optradio">Auslandzahlung</label>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-md-8">
                        <label>Betrag</label>
                        <input type="number" class="form-control"/>
                    </div>
                    <div class="col-md-4">
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
                    <label>IBAN</label>
                    <input type="text" class="form-control"/>
                </div>
            </div>

            <div class="form-group">
                <div>
                    <label>Swift</label>
                    <input type="text" class="form-control"/>
                </div>
            </div>



            <div class="form-group">
                <label class="control-label" for="inputGroup">Beg&uuml;nstigter</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="inputGroup"/>
                    <span class="input-group-addon">
                        <i class="fa fa-search"></i>
                    </span>
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
                <label>F&auml;lligkeit</label>
                <div class="input-group date">
                    <input type='text' class="form-control" id="datepicker"/>
                                    <span class="input-group-addon">
                                     <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                </div>
            </div>

            <div class="form-group">
                <div>
                    <label>Bemerkung</label>
                    <textarea class="form-control" rows="3"></textarea>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label" for="inputGroup">Reise</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="inputGroup"/>
                    <span class="input-group-addon">
                        <i class="fa fa-search"></i>
                    </span>
                </div>
            </div>

            <div class="form-group">
                <label>Rechnung bezahlt?</label> </br>
                <label class="radio-inline"><input type="radio" name="optradio">Ja</label>
                <label class="radio-inline"><input type="radio" name="optradio">Nein</label>
            </div>


            <div class="form-group">
                <button type="submit" class="btn btn-default">Rechnung erfassen</button>
                <button type="reset" class="btn btn-default">Felder l&ouml;schen</button>
            </div>
        </div> <!-- end tab-1 -->
        <div id="editBill" class="tab-pane fade">
            <div class="form-group">
                <h2>Rechnung ansehen / Rechnung editieren</h2> <br/><br/>
            </div>
        </div> <!-- end tab-2 -->
    </div>

</div> <!-- end content div -->



<!--    <script type="text/javascript">
        $(function() {
            $( "#datepicker" ).datepicker();
            dateFormat: "dd-mm-yyyy",
            $.datepicker.setDefaults($.datepicker.regional["de"]);
        });

        $(function() {
            $( "#tabs" ).tabs();
        });


        $(function() {
            var defaultTab = parseInt(getParam('tab'));
            $( "#tabs" ).tabs(
                {active: defaultTab}
            );
        });
        function getParam(name) {
            var query = location.search.substring(1);
            if (query.length) {
                var parts = query.split('&');
                for (var i = 0; i < parts.length; i++) {
                    var pos = parts[i].indexOf('=');
                    if (parts[i].substring(0,pos) == name) {
                        return parts[i].substring(pos+1);
                    }
                }
            }
            return 0;
        }
    </script>-->

<?php
include("includes/footer.inc.php");
?>