
<?php
$pagetitle = "Rechnungen";
include("includes/header.inc.php");
include("includes/navigation.inc.php");





// define variables and set to empty values
$amount_error = $currency_error = $costs_error = "";
$amount = $iban = "";



if(isset($_POST['gesendet'])) {


    if (empty($_POST['amount'])) {
        $amount_error = "Bitte einen Rechnungsbetrag eingeben";
    } else {
        @$amount = $_POST['amount'];
    }
    if (empty($_POST['iban'])){
        $iban_error = "Bitte eine IBAN-Nr. eingeben";
    } else {
        @$iban = $_POST['iban'];
    }

}


?>

<div id="content" class="container">
    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#createBill">Neue Rechnung erfassen</a></li>
        <li><a data-toggle="tab" href="#editBill">Rechnung ansehen / editieren</a></li>
    </ul>

    <div class="tab-content">
        <div id="createBill" class="tab-pane fade in active">
            <form role="form" method="post" action="">
                <h2>Rechnung erfassen</h2> </br></br>
                <div class="form-group">
                    <label>Rechnungs-ID</label>
                    <input class="form-control" type="text" readonly>
                </div>

                <div class="form-group">
                    <label>Einzahlungsart</label> </br>
                    <label class="radio-inline"><input type="radio" name="paymentoption" <?php echo isset($_POST['paymentoption'])&&($_POST['paymentoption'])=='ESR'? ' checked':''; ?>>ESR</label>
                    <label class="radio-inline"><input type="radio" name="paymentoption" <?php echo isset($_POST['paymentoption'])&&($_POST['paymentoption'])=='Roter Einzahlungsschein'? ' checked':''; ?>>Roter Einzahlungsschein</label>
                    <label class="radio-inline"><input type="radio" name="paymentoption" <?php echo isset($_POST['paymentoption'])&&($_POST['paymentoption'])=='Auslandzahlung'? ' checked':''; ?>>Auslandzahlung</label>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-8 <?php echo (!empty($amount_error)) ? 'has-warning':''; ?>">
                            <label>Betrag</label>
                            <input type="number" name="amount" class="form-control"/>
                            <?php echo "<span class='help-block'>$amount_error</span>";?>
                        </div>
                        <div class="col-md-4">
                            <label>W&auml;hrung</label>
                            <select name="currency" class="form-control">
                                <option value="default">W&auml;hlen Sie bitte eine W&auml;hrung</option>
                                <option value="CHF <?php echo isset($_POST['currency'])&&($_POST['currency']=='CHF')?' selected="selected"':'';?>">CHF</option>
                                <option value="EUR <?php echo isset($_POST['currency'])&&($_POST['currency']=='EUR')?' selected="selected"':'';?>">EUR</option>
                                <option value="GBP <?php echo isset($_POST['currency'])&&($_POST['currency']=='GBP')?' selected="selected"':'';?>">GBP</option>
                            </select>

                        </div>
                    </div>

                </div>

                <div class="form-group">

                    <label>IBAN</label>
                    <input type="text" name="iban" class="form-control" />


                </div>

                <div class="form-group">
                    <div>
                        <label>Swift</label>
                        <input type="text" name="swift" class="form-control"/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label" for="inputGroup">Beg&uuml;nstigter</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="recipient" id="inputGroup""/>
                    <span class="input-group-addon">
                        <i class="fa fa-search"></i>
                    </span>
                    </div>
                </div>


                <div class="form-group <?php echo (!empty($costs_error)) ? 'has-warning':''; ?>">
                    <label for="costs">Kostenart</label >
                    <select id="costs" name="costs" class="form-control">
                        <option <?php echo isset($_POST['costs'])=='Administration'? ' selected':'';?>>Administration</option>
                        <option <?php echo isset($_POST['costs'])=='Versicherung'? 'selected':''; ?>>Versicherung</option>
                        <option <?php echo isset($_POST['costs'])=='Treibstoff'? ' selected':''; ?>>Treibstoff</option>
                        <option <?php echo isset($_POST['costs'])=='Andere Kosten'? ' selected':''; ?>>Andere Kosten</option>
                    </select>
                    <?php echo "<p class='text-danger'>$costs_error</p>";?>
                </div>

                <div class="form-group">
                    <label>F&auml;lligkeit</label>
                    <div class="input-group date">
                        <input type='text' class="form-control" name="duedate" id="datepicker"/>
                                    <span class="input-group-addon">
                                     <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                    </div>
                </div>

                <div class="form-group">
                    <div>
                        <label>Bemerkung</label>
                        <textarea class="form-control" rows="3" name="comment"></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label" for="reise">Reise</label>
                    <div class="input-group">
                        <input class="form-control" type="text" name="travelid">
                    <span class="input-group-addon">
                        <i class="fa fa-search"></i>
                    </span>
                    </div>
                </div>

                <div class="form-group">
                    <label>Rechnung bezahlt?</label> </br>
                    <label class="radio-inline"><input type="radio" name="paidBill" <?php echo isset($_POST['paidBill'])=='Ja'? 'checked':''; ?>>Ja</label>
                    <label class="radio-inline"><input type="radio" name="paidBill" <?php echo isset($_POST['paidBill'])=='Nein'? 'checked':''; ?>>Nein</label>
                </div>



                <button type="submit" name="gesendet" class="btn btn-default">Rechnung erfassen</button>
                <button type="reset" class="btn btn-default">Felder l&ouml;schen</button>


            </form>

        </div> <!-- end tab-1 -->

        <div id="editBill" class="tab-pane fade">
            <div class="form-group">
                <h2>Rechnung ansehen / Rechnung editieren</h2> <br/><br/>
            </div>
        </div> <!-- end tab-2 -->
    </div> <!-- end tabs -->
</div> <!-- end content div -->



<script type="text/javascript">

    $(function() {
        $( "#datepicker" ).datepicker();

        dateFormat: "dd-mm-yyyy",
            $.datepicker.setDefaults($.datepicker.regional["de"]);
    });


</script>

<?php
include("includes/footer.inc.php");
?>

