<div class ="modal fade" id="Mutationsformular" tabindex="-1" role="dialog">


    <?php

    $rechnungsID = $_GET["RechnungsID_R"];

    $_POST["RechnungsID_R"] = $rechnungsID;

    include_once("rechnungen.read.php");

    ?>

    <div class="modal-dialog" role="document">

        <div class="modal-content">

            <form role="form" method="post" action="">
                <h2>Rechnung mutieren</h2> </br></br>
                <div class="form-group">
                    <label>Rechnungs-ID</label>
                    <input class="form-control" type="text" readonly>
                </div>

                <div class="form-group">
                    <label>Einzahlungsart</label> </br>
                    <label class="radio-inline"><input type="radio" name="paymentoption" value="ESR">ESR</label>
                    <label class="radio-inline"><input type="radio" name="paymentoption" value="RoterES">Roter Einzahlungsschein</label>
                    <label class="radio-inline"><input type="radio" name="paymentoption" value="Ausland">Auslandzahlung</label>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-8">
                            <label>Betrag</label>
                            <input type="number" name="amount" value="<?php if(!isset($result["Betrag_R"])) echo 666; else echo 667; ?>" class="form-control"/>
                        </div>
                        <div class="col-md-4">
                            <label>W&auml;hrung</label>
                            <select name="currency" class="form-control">
                                <option value="default">W&auml;hlen Sie bitte eine W&auml;hrung</option>
                                <option value="CHF">CHF</option>
                                <option value="EUR">EUR</option>
                                <option value="GBP">GBP</option>
                                <option value="GBP">USD</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>IBAN</label>
                    <input type="text" name="iban" title="Format: CH63 4489 9857 4842 9034 6" class="form-control"/>
                </div>
                <div class="form-group">
                    <label>Swift</label>
                    <input type="text" name="swift" title="Format: LUKBCH2260A" class="form-control" value=""/>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-8">
                            <label>F&auml;lligkeit</label>
                            <input type='text' class="form-control" name="duedate" title="Format [dd.mm.jjjj]"  id="datepicker" value=""/>

                        </div>
                        <div class="col-md-4">
                            <label>Kostenart</label>
                            <select id="costs" name="costs" class="form-control">
                                <option value="default">Kostenart w&auml;hlen</option>
                                <option>Hotel</option>
                                <option>Administration</option>
                                <option>Versicherung</option>
                                <option>Treibstoff</option>
                                <option>Sonstiges</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Beg&uuml;nstigter</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="recipient" name="recipient" value=""/>
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#newRecipient">Neuen Beg&uuml;nstigten anlegen</button>
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
                    <label>Reise</label>
                    <input class="form-control" type="text" id="travel" name="travelid" value=""/>
                </div>
                <div class="form-group">
                    <label>Rechnung bezahlt?</label> </br>
                    <label class="radio-inline"><input type="radio" name="paidBill">Ja</label>
                    <label class="radio-inline"><input type="radio" name="paidBill">Nein</label>
                </div>
                <div class="form-group pull-right">
                    <button type="submit" type="button" name="gesendet" class="btn btn-primary">&Auml;nderungen speichern</button>
                    <button type="reset" class="btn btn-primary">Rechnung l&ouml;schen</button>
                </div>
            </form>
        </div>
    </div>
</div>