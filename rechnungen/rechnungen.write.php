                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  <?php
ini_set('display_errors', E_ALL);
include_once("../classes/database.class.php");
include_once("../classes/rechnung.class.php");
include_once("beguenstigter_modal.php");
include("../includes/authentication.inc.php");


/** @var database $verbindung */
$verbindung = database::getDatabase();

// define variables and set to empty values
$amount_error  = $costs_error = $iban_error=$swift_error=$recipient_error=$duedate_error=$comment_error=$travel_error=$paymentoption_error=$paidBill_error="";
$amount =  $iban = $swift = $duedate= $recipient=$comment=$travel=$paymentoption=$paidBill="";
$valid = true;
$successful = false;
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

    else return false;

}

function format_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    return $data;
}

if(isset($_POST["zuruecksetzen"])){

    unset($_POST['paymentoption']);
    unset($_POST['amount']);
    unset($_POST['iban']);
    unset($_POST['swift']);
    unset($_POST['recipient']);
    unset($_POST['costs']);
    unset($_POST['duedate']);
    unset($_POST['comment']);
    unset($_POST['travelid']);
    unset($_POST['paidBill']);


}

if(isset($_POST['gesendet'])) {
    if (empty(format_input(@$_POST['paymentoption']))) {
        $paymentoption_error = "Bitte eine Zahlungsart eingeben";
        $valid = false;
    }
    if (empty(format_input($_POST['amount']))) {
        $amount_error = "Bitte einen Rechnungsbetrag eingeben";
        $valid = false;
    }elseif(is_nan(format_input($_POST['amount'])) && (!(in_array(format_input($_POST['amount']), range(1, 500000))))){
        $amount_error = $amount_error . "Bitte nur Betr&auml;ge zwischen 1 und 500000.";
        $valid = false;
    }

    if (empty(format_input($_POST['iban']))){
        $iban_error = "Bitte eine IBAN-Nr. eingeben";
        $valid = false;

    }elseif(!(preg_match("/[a-zA-Z]{2}\d{2}[ ]\d{4}[ ]\d{4}[ ]\d{4}[ ]\d{4}[ ]\d{1}|[a-zA-Z]{2}\d{22}/", format_input($_POST['iban'])))){
        $iban_error = $iban_error. "Bitte ein korrektes Format eingeben";
        $valid = false;
    }
    if (empty(format_input($_POST['swift']))){
        $swift_error = "Bitte eine Swift-Nr. eingeben";
        $valid = false;
    }elseif(!(preg_match('/^[a-z]{6}[0-9a-z]{2}([0-9a-z]{3})?\z/i', format_input($_POST['swift'])))){
        $swift_error = $swift_error . "Bitte ein korrektes Format eingeben";
        $valid = false;
    }
    if (empty(format_input($_POST['recipient']))){
        $recipient_error = "Bitte einen Begünstigten eingeben";
        $valid = false;
    }elseif(!is_numeric($_POST["recipient"])){
        $recipient_error = "Bitte einen korrekten Begünstigten eingeben";
        $valid = false;
    }elseif(!$verbindung->existsBeguenstigter(format_input($_POST["recipient"]))){
        $recipient_error = "Bitte einen korrekten Begünstigten eingeben";
        $valid = false;
    }

    if (format_input($_POST['costs'])=='default') {
        $costs_error = "Bitte eine Kostenart eingeben";
        $valid = false;
    }
    if (empty(format_input($_POST['duedate']))){
        $duedate_error = "Bitte ein F&auml;llikeitsdatum eingeben";
        $valid = false;
    }else if (is_valid_date(format_input($_POST['duedate']))==false) {
        $duedate_error = $duedate_error. "Bitte ein korrektes Datumsformat ['dd.mm.jjjj'] eingeben";
        $valid = false;
    }
    if (empty(format_input($_POST['comment']))){
        $comment_error = "Bitte ein Kommentar eingeben";
        $valid = false;
    }
    if (empty(format_input($_POST['travelid']))){
        $travel_error = "Bitte Rechnung einer Reise zuordnen.";
        $valid = false;
    }elseif(!is_numeric($_POST["travelid"])){
        $travel_error = "Bitte eine korrekte Reise eingeben";
        $valid = false;
    }elseif(!$verbindung->existsReise(format_input($_POST["travelid"]))){
        $travel_error = "Bitte eine korrekte Reise eingeben";
        $valid = false;
    }
    if (empty($_POST['paidBill'])){
        $paidBill_error = "Bitte angeben, ob Rechnung bezahlt ist oder nicht.";
        $valid = false;
    }
    if ($valid) {

        $pay = 0;
        if ($_POST['paidBill'] == 'Ja') {
            $pay = 1;
        } else {
            $pay = 0;
        }


        $billData = array();

        $billData['Rechnungsart'] = format_input($_POST['paymentoption']);
        $billData['Betrag'] = format_input($_POST['amount']);
        $billData['IBAN'] = format_input($_POST['iban']);
        $billData['SWIFT'] = format_input($_POST['swift']);
        $billData['Beguenstigter'] = format_input($_POST['recipient']);
        $billData['Kostenart'] = format_input($_POST['costs']);
        $billData['Faelligkeit'] = date("Y-m-d",strtotime(format_input($_POST['duedate'])));
        $billData['Bemerkung'] = format_input($_POST['comment']);
        $billData['Reise'] = format_input($_POST['travelid']);
        $billData['bezahlt'] = $pay;


        //create Rechnungsobjekt
        $rechnung = rechnung::newRechnung($billData);

        $command = $verbindung->insertRechnung($rechnung);

        if($command){
            unset($_POST['paymentoption']);
            unset($_POST['amount']);
            unset($_POST['iban']);
            unset($_POST['swift']);
            unset($_POST['recipient']);
            unset($_POST['costs']);
            unset($_POST['duedate']);
            unset($_POST['comment']);
            unset($_POST['travelid']);
            unset($_POST['paidBill']);
            $success_alert = "<div class='alert alert-success' role='alert'>Neue Rechnung erfasst.</div>";
        }else{
            $error_alert = "<div class='alert alert-warning' role='alert'>Datenbank-Befehl fehlgeschlagen.</div>";
        }
    }else{
        $error_alert = "<div class='alert alert-warning' role='alert'>Das Formular enthält Fehler/Unvollständigkeiten.</div>";
    }

}
?>

<form role="form" method="post" action="">
    <h2>Rechnung erfassen</h2> </br></br>
    <?php echo (!empty($valid)) ? $success_alert: $error_alert; ?>
    <div class="form-group">
        <label>Rechnungs-ID</label>
        <input class="form-control" name="id" type="text"<?php
        /** @var database $database*/
        $database = database::getDatabase();
        $result = $database->getID('RechnungsID', 'Rechnung');

        while ($row = mysqli_fetch_assoc($result)){
            settype($row['id'], "int");
            $id = $row['id'] +1;
            echo "value=".$id;
        }
        ?> readonly>
    </div>

    <div class="form-group <?php echo (!empty($paymentoption_error)) ? 'has-error':''; ?>">
        <label>Einzahlungsart</label> </br>
        <label class="radio-inline"><input type="radio" name="paymentoption" value="ESR" <?php echo isset($_POST['paymentoption'])=='ESR'? ' checked':''; ?>>ESR</label>
        <label class="radio-inline"><input type="radio" name="paymentoption" value="RoterES" <?php echo isset($_POST['paymentoption'])=='RoterES'? ' checked':''; ?>>Roter Einzahlungsschein</label>
        <label class="radio-inline"><input type="radio" name="paymentoption" value="Ausland" <?php echo isset($_POST['paymentoption'])=='Ausland'? ' checked':''; ?>>Auslandzahlung</label>
        <?php echo "<span class='help-block'>$paymentoption_error</span>";?>
    </div>

    <div class="form-group  <?php echo (!empty($amount_error)) ? 'has-error':''; ?>">
        <label>Betrag in CHF</label>
        <input type="number" step="any" name="amount" value="<?php echo @$_POST['amount'];?>" class="form-control"/>
        <?php echo "<span class='help-block'>$amount_error</span>";?>
    </div>
    <div class="form-group <?php echo (!empty($iban_error)) ? 'has-error':''; ?>">
        <label>IBAN</label>
        <input type="text" name="iban" title="Format: CH63 4489 9857 4842 9034 6" class="form-control" value="<?php echo @$_POST['iban'];?>"/>
        <?php echo "<span class='help-block'>$iban_error</span>";?>
    </div>
    <div class="form-group <?php echo (!empty($swift_error)) ? 'has-error':''; ?>">
        <label>Swift</label>
        <input type="text" name="swift" title="Format: LUKBCH2260A" class="form-control" value="<?php echo @$_POST['swift'];?>"/>
        <?php echo "<span class='help-block'>$swift_error</span>";?>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-8 <?php echo (!empty($duedate_error)) ? ' has-error':''; ?>">
                <label>F&auml;lligkeit</label>
                <input type='text' class="form-control" name="duedate" title="Format [dd.mm.jjjj]"  id="datepicker" value="<?php echo @$_POST['duedate'];?>"/>
                <?php echo "<div><p class='help-block'>$duedate_error</p></div>";?>
            </div>
            <div class="col-md-4 <?php echo (!empty($costs_error)) ? ' has-error':''; ?>">
                <label>Kostenart</label>
                <select id="costs" name="costs" class="form-control">
                    <option value="default">Kostenart wählen</option>
                    <option <?php echo isset($_POST['costs'])&&($_POST['costs']=='Hotel')? ' selected="selected"':''; ?>>Hotel</option>
                    <option <?php echo isset($_POST['costs'])&&($_POST['costs']=='Administration')? ' selected="selected"':'';?>>Administration</option>
                    <option <?php echo isset($_POST['costs'])&&($_POST['costs']=='Versicherung')? ' selected="selected"':''; ?>>Versicherung</option>
                    <option <?php echo isset($_POST['costs'])&&($_POST['costs']=='Treibstoff')? ' selected="selected"':''; ?>>Treibstoff</option>
                    <option <?php echo isset($_POST['costs'])&&($_POST['costs']=='Sonstiges')? ' selected="selected"':''; ?>>Sonstiges</option>
                </select>
                <?php echo "<span class='help-block'>$costs_error</span>";?>
            </div>
        </div>
    </div>

    <div class="form-group <?php echo (!empty($recipient_error)) ? 'has-error':''; ?>">
        <label>Begünstigter</label>
        <div class="input-group">
            <input type="text" class="form-control" id="recipient" name="recipient" value="<?php echo @$_POST['recipient'];?>"/>
            <span class="input-group-btn">
                <button class="btn btn-primary" type="button" data-toggle="modal" id="rec" data-target="#newRecipient">Neuen Begünstigten anlegen</button>
            </span>
        </div>
        <?php echo "<span class='help-block'>$recipient_error</span>";?>
    </div>

    <div class="form-group <?php echo (!empty($comment_error)) ? ' has-error':''; ?>">
        <div>
            <label>Bemerkung</label>
            <textarea class="form-control" rows="3" name="comment"><?php echo @$_POST['comment']?></textarea>
            <?php echo "<div><p class='help-block'>$comment_error</p></div>";?>
        </div>
    </div>
    <div class="form-group <?php echo (!empty($travel_error)) ? ' has-error':''; ?>">
        <label>Reise</label>
        <input class="form-control" type="text" id="travel" name="travelid" value="<?php echo @$_POST['travelid'];?>"/>
        <?php echo "<div><p class='help-block'>$travel_error</p></div>";?>
    </div>
    <div class="form-group <?php echo (!empty($paidBill_error)) ? ' has-error':''; ?>">
        <label>Rechnung bezahlt?</label> </br>
        <label class="radio-inline"><input type="radio" name="paidBill" <?php echo isset($_POST['paidBill'])=='Ja'? 'checked':''; ?>>Ja</label>
        <label class="radio-inline"><input type="radio" name="paidBill" <?php echo isset($_POST['paidBill'])=='Nein'? 'checked':''; ?>>Nein</label>
        <?php echo "<div><p class='help-block'>$paidBill_error</p></div>";?>
    </div>
    <div class="form-group pull-right">
        <button type="submit" type="button" name="gesendet" class="btn btn-primary">Rechnung erfassen</button>
        <button type="submit" name="zuruecksetzen" class="btn btn-primary">Felder l&ouml;schen</button>
    </div>
</form>

<script type="text/javascript">
    $(function() {

        $( "#datepicker" ).datepicker();
        "dd-mm-yyyy",
            $.datepicker.setDefaults($.datepicker.regional["de"]);


        $( "#recipient" ).autocomplete({
            source: function( request, response ) {
                $.ajax({
                    url: "../autosuggest_recipient.php",
                    dataType: "json",
                    data: {term: request.term},
                    success: function (data) {
                        if(data.length > 0){
                            response($.map(data, function (item) {
                                return {
                                    label: item.label,
                                    value: item.value
                                }
                            }));
                        }else{
                            response([{ label: 'No results found.', value: -1}]);
                        }
                    }
                });
            },
            select: function (event, ui) {

                if (ui.item.value == -1) {
                    return false;
                }
            }

        });


        $( "#travel" ).autocomplete({

            source: function( request, response ) {
                $.ajax({
                    url: "../autosuggest_travelid.php",
                    dataType: "json",
                    data: {term: request.term},
                    success: function (data) {
                        if(data.length > 0){
                            response($.map(data, function (item) {
                                return {
                                    label: item.label,
                                    value: item.value
                                }
                            }));
                        }else{
                            response([{ label: 'No results found.', value: -1}]);
                        }
                    }
                });
            },

            select: function (event, ui) {

                if (ui.item.value == -1) {
                    return false;
                }
            }

        });
    });
</script>