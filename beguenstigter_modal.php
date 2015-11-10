<?php
$recipientData = array();
if(isset($_POST['newRecipient'])) {
    //$recipientData = array();
    $recipientData['beguenstigterName'] = $_POST['name'];
    $recipientData['strasse'] = $_POST['street'];
    $recipientData['hausnummer'] = $_POST['housenumber'];
    $recipientData['plz'] = $_POST['plz'];
    $recipientData['ort'] = $_POST['town'];




//create Rechnungsobjekt
    $recipient = beguenstigter::newBeguenstigter($recipientData);

//make insert-statement
    /** @var database $verbindung */

    $verbindung = database::getDatabase();
    $successful = $verbindung->insertBeguenstigter($recipient);

    if($successful){

    //set all variables to default
    unset($_POST['name']);
    unset($_POST['street']);
    unset($_POST['housenumber']);
    unset($_POST['plz']);
    unset($_POST['town']);

    }



}


?>
<!-- Modal for new Recipient -->
<div class="modal fade" id="newRecipient" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Neuen Beg&uuml;nstigten erfassen</h4>
            </div>
            <div class="modal-body">

                <form action="beguenstigter_modal.php" method="post">
                        <div class="form-group">
                            <label>Beg&uuml;nstigten-ID</label>
                            <input class="form-control" type="text" readonly>
                        </div>
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" />
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-8">
                                    <label>Strasse</label>
                                    <input type="text" name="street" class="form-control"/>
                                </div>
                                <div class="col-md-4">
                                    <label>Hausnummer</label>
                                    <input type="number" name="housenumber" class="form-control"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-8">
                                    <label>PLZ</label>
                                    <input type="number" name="plz" class="form-control"/>
                                </div>
                                <div class="col-md-4">
                                    <label>Ort</label>
                                    <input type="text" name="town" class="form-control"/>
                                </div>
                            </div>
                        </div>
                    </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Abbrechen</button>
                <button type="button" type="submit" name ="newRecipient" data-dismiss="modal" class="btn btn-primary">Neuen Beg&uuml;nstigten anlegen</button>
            </div>
        </div>
    </div>
</div>
