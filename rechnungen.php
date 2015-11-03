<?php
ini_set('display_errors', E_ALL);
$pagetitle = "Rechnungen";
include("includes/header.inc.php");
include("includes/navigation.inc.php");

// define variables and set to empty values
$amount_error = $currency_error = $costs_error = $iban_error=$swift_error=$recipient_error=$duedate_error=$comment_error=$travel_error=$paymentoption_error=$paidBill_error="";
$amount =  $iban = $swift = $duedate= $recipient=$comment=$travel=$paymentoption=$paidBill="";


$valid = true;
$success_alert="";
$error_alert="";


function is_valid_date($enddatum) {
    @$enddatum_array = explode('.',$enddatum);
    @$tag=$enddatum_array[0];
    @$monat=$enddatum_array[1];
    @$jahr=$enddatum_array[2];

    if (is_numeric($tag) && is_numeric($monat) && is_numeric($jahr))
    {
        return checkdate($monat, $tag, $jahr); //returns true or false
    }
}


if(isset($_POST['gesendet'])) {
    if (empty($_POST['paymentoption'])) {
        $paymentoption_error = "Bitte eine Zahlungsart eingeben";
        $valid = false;
    }

    if (empty($_POST['amount'])) {
        $amount_error = "Bitte einen Rechnungsbetrag eingeben";
        $valid = false;
    }

    if ($_POST['currency']=='default') {
        $currency_error = "Bitte eine W&auml;hrung eingeben";
        $valid = false;
    }
    if (empty($_POST['iban'])){
        $iban_error = "Bitte eine IBAN-Nr. eingeben";
        $valid = false;
    }
    if (empty($_POST['swift'])){
        $swift_error = "Bitte eine Swift-Nr. eingeben";
        $valid = false;
    }
    if (empty($_POST['recipient'])){
        $recipient_error = "Bitte einen Beg&uuml;nstigten eingeben";
        $valid = false;
    }
    if ($_POST['costs']=='default') {
        $costs_error = "Bitte eine Kostenart eingeben";
        $valid = false;
    }
    if (empty($_POST['duedate'])){
        $duedate_error = "Bitte ein F&auml;llikeitsdatum eingeben";
        $valid = false;
    }else if (is_valid_date($_POST['duedate'])==false) {
        $duedate_error = "Bitte ein korrektes Datumsformat ['dd.mm.jjjj'] eingeben";
        $valid = false;
    }




    if (empty($_POST['comment'])){
        $comment_error = "Bitte ein Kommentar eingeben";
        $valid = false;
    }
    if (empty($_POST['travelid'])){
        $travel_error = "Bitte Rechnung einer Reise zuordnen.";
        $valid = false;
    }
    if (empty($_POST['paidBill'])){
        $paidBill_error = "Bitte angeben, ob Rechnung bezahlt ist oder nicht.";
        $valid = false;
    }

if ($valid) {
    $success_alert= "<div class='alert alert-success' role='alert'>Neue Rechnung erfasst.</div>";

    //database transaktion "insert-command"


}else{
    $error_alert = "<div class='alert alert-warning' role='alert'>Es sind Fehler aufgetreten.</div>";
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
            <form role="form" method="post" action="rechnungen.php">
                <h2>Rechnung erfassen</h2> </br></br>
                <?php echo ($valid) ? $success_alert: $error_alert; ?>
                <div class="form-group">
                    <label>Rechnungs-ID</label>
                    <input class="form-control" type="text" readonly>
                </div>

                <div class="form-group <?php echo (!empty($paymentoption_error)) ? 'has-error':''; ?>">
                    <label>Einzahlungsart</label> </br>
                    <label class="radio-inline"><input type="radio" name="paymentoption" <?php echo isset($_POST['paymentoption'])=='ESR'? ' checked':''; ?>>ESR</label>
                    <label class="radio-inline"><input type="radio" name="paymentoption" <?php echo isset($_POST['paymentoption'])=='Roter Einzahlungsschein'? ' checked':''; ?>>Roter Einzahlungsschein</label>
                    <label class="radio-inline"><input type="radio" name="paymentoption" <?php echo isset($_POST['paymentoption'])=='Auslandzahlung'? ' checked':''; ?>>Auslandzahlung</label>
                    <?php echo "<span class='help-block'>$paymentoption_error</span>";?>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-8 <?php echo (!empty($amount_error)) ? 'has-error':''; ?>">
                            <label>Betrag</label>
                            <input type="number" name="amount" value="<?php echo @$_POST['amount'];?>" class="form-control"/>
                            <?php echo "<span class='help-block'>$amount_error</span>";?>
                        </div>
                        <div class="col-md-4 <?php echo (!empty($currency_error)) ? 'has-error':''; ?>">
                            <label>W&auml;hrung</label>
                            <select name="currency" class="form-control">
                                <option value="default">W&auml;hlen Sie bitte eine W&auml;hrung</option>
                                <option value="CHF" <?php echo isset($_POST['currency'])&&($_POST['currency']=='CHF')?' selected="selected"':'';?>">CHF</option>
                                <option value="EUR" <?php echo isset($_POST['currency'])&&($_POST['currency']=='EUR')?' selected="selected"':'';?>">EUR</option>
                                <option value="GBP" <?php echo isset($_POST['currency'])&&($_POST['currency']=='GBP')?' selected="selected"':'';?>">GBP</option>
                            </select>
                            <?php echo "<span class='help-block'>$currency_error</span>";?>
                        </div>
                    </div>
                </div>

                <div class="form-group <?php echo (!empty($iban_error)) ? 'has-error':''; ?>">
                    <label>IBAN</label>
                    <input type="text" name="iban" class="form-control" value="<?php echo @$_POST['iban'];?>"/>
                    <?php echo "<span class='help-block'>$iban_error</span>";?>

                </div>

                <div class="form-group <?php echo (!empty($swift_error)) ? 'has-error':''; ?>">

                    <label>Swift</label>
                    <input type="text" name="swift" class="form-control" value="<?php echo @$_POST['swift'];?>"/>
                    <?php echo "<span class='help-block'>$swift_error</span>";?>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-8 <?php echo (!empty($recipient_error)) ? 'has-error':''; ?>">
                            <label>Beg&uuml;nstigter</label>
                            <input type="text" class="form-control" name="recipient" value="<?php echo @$_POST['recipient'];?>"/>
                            <?php echo "<span class='help-block'>$recipient_error</span>";?>
                        </div>
                        <div class="col-md-4 <?php echo (!empty($costs_error)) ? ' has-error':''; ?>">
                            <label>Kostenart</label>
                            <select id="costs" name="costs" class="form-control">
                                <option value="default">Kostenart w&auml;hlen</option>
                                <option <?php echo isset($_POST['costs'])&&($_POST['costs']=='Administration')? ' selected="selected"':'';?>>Administration</option>
                                <option <?php echo isset($_POST['costs'])&&($_POST['costs']=='Versicherung')? ' selected="selected"':''; ?>>Versicherung</option>
                                <option <?php echo isset($_POST['costs'])&&($_POST['costs']=='Treibstoff')? ' selected="selected"':''; ?>>Treibstoff</option>
                                <option <?php echo isset($_POST['costs'])&&($_POST['costs']=='Andere Kosten')? ' selected="selected"':''; ?>>Andere Kosten</option>
                            </select>
                            <?php echo "<span class='help-block'>$costs_error</span>";?>
                        </div>
                    </div>
                </div>




                <div class="form-group <?php echo (!empty($duedate_error)) ? ' has-error':''; ?>">
                    <label>F&auml;lligkeit</label>
                    <input type='text' class="form-control" name="duedate" title="Format [dd.mm.jjjj]"  id="datepicker" value="<?php echo @$_POST['duedate'];?>"/>
                    <?php echo "<div><p class='help-block'>$duedate_error</p></div>";?>
                </div>

                <div class="form-group <?php echo (!empty($comment_error)) ? ' has-error':''; ?>">
                    <div>
                        <label>Bemerkung</label>
                        <textarea class="form-control" rows="3" name="comment"><?php echo @$_POST['comment']?></textarea>
                        <?php echo "<div><p class='help-block'>$comment_error</p></div>";?>
                    </div>
                </div>

                <div class="form-group <?php echo (!empty($travel_error)) ? ' has-error':''; ?>">
                    <label class="control-label">Reise</label>
                    <input class="form-control" type="text" name="travelid" value="<?php echo @$_POST['travelid'];?>"/>
                    <?php echo "<div><p class='help-block'>$travel_error</p></div>";?>
                </div>


        <div class="form-group <?php echo (!empty($paidBill_error)) ? ' has-error':''; ?>">
            <label>Rechnung bezahlt?</label> </br>
            <label class="radio-inline"><input type="radio" name="paidBill" <?php echo isset($_POST['paidBill'])=='Ja'? 'checked':''; ?>>Ja</label>
            <label class="radio-inline"><input type="radio" name="paidBill" <?php echo isset($_POST['paidBill'])=='Nein'? 'checked':''; ?>>Nein</label>
            <?php echo "<div><p class='help-block'>$paidBill_error</p></div>";?>
        </div>

                <div class="form-group pull-right">
                <button type="submit" name="gesendet" class="btn btn-primary">Rechnung erfassen</button>
                <button type="reset" class="btn btn-primary">Felder l&ouml;schen</button>
                </div>
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