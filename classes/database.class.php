<?php

include_once("beguenstigter.class.php");

class database
{
    private static $database;
    private $host;
    private $benutzer;
    private $passwort;
    private $dbname;
    private $link;

    private function __construct(){

        $this->host = '127.0.0.1';
        $this->benutzer = 'root';
        $this->passwort ='';
        $this->dbname = 'reiseunternehmen';
        $this->link = mysqli_connect($this->host, $this->benutzer, $this->passwort, $this->dbname);
    }

    public static function getDatabase(){

        if (database::$database == null) database::$database = new Database();

        return database::$database;

    }

    public function insertBeguenstigter(beguenstigter $beguenstigter){

        $id = $beguenstigter->getBeguenstigterID();
        $name = $beguenstigter->getBeguenstigterName();
        $strasse = $beguenstigter->getStrasse();
        $hausnummer = $beguenstigter->getHausnummer();
        $ort = $beguenstigter->getOrt();
        $plz = $beguenstigter->getPlz();

        if(!$this->existsOrt($plz)) $this->insertOrt($plz, $ort);

        /**  @var database $database */
        $database = database::getDatabase();
        $link = $database->getLink();

        if($id == "DEFAULT"){

            $query = "INSERT INTO beguenstigter (BeguenstigterName, Strasse, Hausnummer, Ort) VALUES (?, ?, ?, ?)";
            $stmt = $link->prepare($query);
            $stmt->bind_param('sssi', $name, $strasse, $hausnummer, $plz);

        }

        else {

            $query = "UPDATE beguenstigter SET BeguenstigterName = ?, Strasse = ?, Hausnummer = ?, Ort = ?  WHERE BeguenstigterID = ?";
            $stmt = $link->prepare($query);
            $stmt->bind_param('sssii',$name, $strasse, $hausnummer, $plz, $id);

        }

        if($stmt->execute()) {

            $stmt->close();
            return true;

        }

        else {

            $stmt->close();
            return false;

        }

    }

    public function fetchBeguenstigter($beguenstigterID = null, $beguenstigterName = null){

        /* @var database $database*/
        $database = database::getDatabase();
        $link = $database->getLink();

        if(is_null($beguenstigterID)&& is_null($beguenstigterName)) return false;

        else if(!is_null($beguenstigterID)) {

            $query = "SELECT * FROM beguenstigter WHERE BeguenstigterID = ?";
            $stmt = $link->prepare($query);
            $stmt->bind_param('i',$beguenstigterID);

        }

        else {

            $query = "SELECT * FROM beguenstigter WHERE BeguenstigterName = ?";
            $stmt = $link->prepare($query);
            $stmt->bind_param('i',$beguenstigterName);

        }

        $stmt->execute();
        $stmt->bind_result($beguenstigterID, $beguenstigterName, $strasse, $hausnummer, $ort);

        $stmt->fetch();
        $stmt->close();

        $beg["BeguenstigterID"] = $beguenstigterID;
        $beg["BeguenstigterName"] = $beguenstigterName;
        $beg["Strasse"] = $strasse;
        $beg["Hausnummer"] = $hausnummer;
        $beg["PLZ"] = $ort;
        $beg["Ort"] = $this->fetchOrt($ort)["Ort"];

        $beguenstigter = beguenstigter::newBeguenstigter($beg);

        return $beguenstigter;

    }

    public function existsBeguenstigter($beguenstigterID){

        /* @var database $database*/
        $database = database::getDatabase();
        $link = $database->getLink();

        $query = "SELECT BeguenstigterID, BeguenstigterName FROM beguenstigter WHERE BeguenstigterID = ?";

        $stmt = $link->prepare($query);
        $stmt->bind_param('i', $beguenstigterID);

        $stmt->execute();

        $stmt->bind_result($beguenstigterID,$beguenstigterName);

        $enthalten = false;

        while($stmt->fetch()){

            $enthalten = true;
            break;

        }
        $stmt->close();
        return $enthalten;

    }

    public function insertReise(reise $reise){

        $id = $reise->getReiseID();
        $ziel = $reise->getZiel();
        $beschreibung = $reise->getBeschreibung();
        $bezeichnung = $reise->getBezeichnung();
        $preis = $reise->getPreis();
        $hinreise = $reise->getHinreise();
        $rueckreise = $reise->getRueckreise();

        /** @var database $database*/
        $database = database::getDatabase();
        $link = $database->getLink();

        if($id == "DEFAULT") {

            $query = "INSERT INTO reise (Ziel, Beschreibung, Bezeichnung, Preis, Hinreise, Rueckreise) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $link->prepare($query);
            $stmt->bind_param('sssdss', $ziel,$beschreibung, $bezeichnung, $preis, $hinreise, $rueckreise);

        }

        else {

            $query = "UPDATE reise SET Ziel = ?, Beschreibung = ?, Bezeichnung = ?, Preis = ?, Hinreise = ?, Rueckreise = ? WHERE ReiseID = ?";
            $stmt = $link->prepare($query);
            $stmt->bind_param('sssdssi', $ziel, $beschreibung, $bezeichnung, $preis, $hinreise, $rueckreise, $id);

        }

        if($stmt->execute()) {

            $stmt->close();
            return true;

        }

        else {

            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            $stmt->close();
            return false;

        }

    }

    public function fetchReise($reiseID = null, $reiseZiel = null){

        /* @var database $database*/
        $database = database::getDatabase();
        $link = $database->getLink();

        if(is_null($reiseID)&& is_null($reiseZiel)) return false;

        else if(!is_null($reiseID)) {

            $query = "SELECT * FROM reise WHERE ReiseID = ?";
            $stmt = $link->prepare($query);
            $stmt->bind_param('i', $reiseID);

        }

        else {

            $query = "SELECT * FROM reise WHERE Ziel = ?";
            $stmt = $link->prepare($query);
            $stmt->bind_param('i', $reiseZiel);

        }

        $stmt->execute();
        $stmt->bind_result($reiseID, $reiseZiel, $beschreibung, $bezeichnung, $preis, $hinreise, $rueckreise);

        $stmt->fetch();
        $stmt->close();

        $rei["ReiseID"] = $reiseID;
        $rei["Ziel"] = $reiseZiel;
        $rei["Beschreibung"] = $beschreibung;
        $rei["Bezeichnung"] = $bezeichnung;
        $rei["Preis"] = $preis;
        $rei["Hinreise"] = $hinreise;
        $rei["Rueckreise"] = $rueckreise;

        $reise = reise::newReise($rei);

        return $reise;
    }

    public function existsReise($reiseID){

        /* @var database $database*/
        $database = database::getDatabase();
        $link = $database->getLink();

        $query = "SELECT ReiseID, Ziel FROM reise WHERE ReiseID = ?";

        $stmt = $link->prepare($query);
        $stmt->bind_param('i', $reiseID);

        $stmt->execute();

        $stmt->bind_result($reiseID,$ziel);

        $enthalten = false;

        while($stmt->fetch()){

            $enthalten = true;
            break;

        }
        $stmt->close();
        return $enthalten;

    }

    public function insertRechnung(rechnung $rechnung){

        $id = $rechnung->getRechnungsID();
        $rechnungsart = $rechnung->getRechnungsart();
        $betrag = $rechnung->getBetrag();
        $waehrung = $rechnung->getWaehrung();
        $iban = $rechnung->getIban();
        $swift = $rechnung->getSwift();
        $beguenstigter = $rechnung->getBeguenstigter();
        $kostenart = $rechnung->getKostenart();
        $faelligkeit = $rechnung->getFaelligkeit();
        $bemerkung = $rechnung->getBemerkung();
        $reise = $rechnung->getReise();
        $bezahlt = $rechnung->isBezahlt();

        if(!$this->existsBeguenstigter($beguenstigter)) $this->insertBeguenstigter($beguenstigter);

        /** @var database $database */
        $database = database::getDatabase();
        $link = $database->getLink();

        if($id == "DEFAULT") {

            $query = "INSERT INTO rechnung (Rechnungsart, Betrag, Waehrung, IBAN, SWIFT, Beguenstigter, Kostenart, Faelligkeit, Bemerkung, Reise, bezahlt) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $link->prepare($query);
            $stmt->bind_param('sdsssisssii', $rechnungsart, $betrag, $waehrung, $iban, $swift, $beguenstigter, $kostenart, $faelligkeit, $bemerkung, $reise, $bezahlt);

        }
        else {

            $query = "UPDATE rechnung SET Rechnungsart = ?, Betrag = ?, Waehrung = ?, IBAN = ?, SWIFT = ?, Beguenstigter = ?, Kostenart = ?, Faelligkeit = ?, Bemerkung = ?, Reise = ?, bezahlt = ? WHERE RechnungsID = ?";
            $stmt = $link->prepare($query);
            $stmt->bind_param('sdsssisssiii', $rechnungsart, $betrag, $waehrung, $iban, $swift, $beguenstigter, $kostenart, $faelligkeit, $bemerkung, $reise, $bezahlt, $id);

        }

        if($stmt->execute()) {

            $stmt->close();
            return true;

        }

        else {

            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            $stmt->close();
            return false;

        }

    }

    public function fetchRechnung($rechnungsID = null, $reiseID = null){


        /* @var database $database*/
        $database = database::getDatabase();
        $link = $database->getLink();

        if(is_null($reiseID)&& is_null($rechnungsID)) return false;

        else if(!is_null($rechnungsID)) {

            $query = "SELECT * FROM rechnung WHERE RechnungsID = ?";
            $stmt = $link->prepare($query);
            $stmt->bind_param('i', $rechnungsID);

        }

        else {

            $query = "SELECT * FROM rechnung WHERE ReiseID = ?";
            $stmt = $link->prepare($query);
            $stmt->bind_param('i',$reiseID);

        }


        $stmt->execute();
        $stmt->bind_result($rechnungsID, $rechnungsart, $betrag, $waehrung, $iban, $swift, $beguenstigter, $kostenart, $faelligkeit, $bemerkung, $reise, $bezahlt);
        $stmt->fetch();
        $stmt->close();

        $rg ["RechnungsID"] = $rechnungsID;
        $rg ["Rechnungsart"] = $rechnungsart;
        $rg ["Betrag"] = $betrag;
        $rg ["Waehrung"] = $waehrung;
        $rg ["IBAN"] = $iban;
        $rg ["SWIFT"] = $swift;
        $rg ["Beguenstigter"] = $beguenstigter;
        $rg ["Kostenart"] = $kostenart;
        $rg ["Faelligkeit"] = $faelligkeit;
        $rg ["Bemerkung"] = $bemerkung;
        $rg ["Reise"] = $reise;
        $rg ["bezahlt"] = $bezahlt;

        $rechnung = rechnung::newRechnung($rg);

        return $rechnung;

    }

    public function existsRechnung($rechnungsID){

        /* @var database $database*/
        $database = database::getDatabase();
        $link = $database->getLink();

        $query = "SELECT RechnungsID FROM rechnung WHERE RechnungsID = ?";

        $stmt = $link->prepare($query);
        $stmt->bind_param('i', $rechnungsID);

        $stmt->execute();

        $stmt->bind_result($rechnungsID);

        $enthalten = false;

        while($stmt->fetch()){

            $enthalten = true;
            break;

        }

        $stmt->close();
        return $enthalten;
    }

    public function insertTeilnehmner(teilnehmer $teilnehmer){

        $id = $teilnehmer->getTeilnehmerID();
        $vorname = $teilnehmer->getVorname();
        $nachname = $teilnehmer->getNachname();
        $strasse = $teilnehmer->getStrasse();
        $hausnummer = $teilnehmer->getHausnummer();
        $plz = $teilnehmer->getPlz();
        $ort = $teilnehmer->getOrt();
        $telefon = $teilnehmer->getTelefonNr();
        $mail = $teilnehmer->getEmail();

        if(!$this->existsOrt($plz)) $this->insertOrt($plz, $ort);

        /** @var database $database*/
        $database = database::getDatabase();
        $link = $database->getLink();

        if($id == "DEFAULT") {

            $query = "INSERT INTO teilnehmer (Vorname, Nachname, Strasse, Hausnummer, Ort, Telefon, Mail) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $link->prepare($query);
            $stmt->bind_param('ssssiis', $vorname, $nachname, $strasse, $hausnummer, $plz, $telefon, $mail);

        }

        else {

            $query = "UPDATE teilnehmer SET Vorname = ?, Nachname = ?, Strasse = ?, Hausnummer = ?, Ort = ?, Telefon = ?, Mail = ? WHERE TeilnehmerID = ?";
            $stmt = $link->prepare($query);
            $stmt->bind_param('ssssiisi', $vorname, $nachname, $strasse, $hausnummer, $plz, $telefon, $mail, $id);

        }


        if($stmt->execute()) {

            $stmt->close();
            return true;

        }
        else {

            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            $stmt->close();
            return false;

        }

    }

    public function fetchTeilnehmer($teilnehmerID = null, $teilnehmerName = null){

        /* @var database $database*/
        $database = database::getDatabase();
        $link = $database->getLink();

        if(is_null($teilnehmerID) && is_null($teilnehmerName)) return false;

        else if(!is_null($teilnehmerID)) {

            $query = "SELECT * FROM teilnehmer WHERE TeilnehmerID = ?";
            $stmt = $link->prepare($query);
            $stmt->bind_param('i', $teilnehmerID);

        }

        else {

            $query = "SELECT * FROM teilnehmer WHERE Nachname = ?";
            $stmt = $link->prepare($query);
            $stmt->bind_param('s', $teilnehmerName);

        }

        $stmt->execute();
        $stmt->bind_result($teilnehmerID, $vorname, $nachname, $strasse, $hausnummer, $ort, $telefon, $mail);
        $stmt->fetch();
        $stmt->close();

        $teiln ["TeilnehmerID"] = $teilnehmerID;
        $teiln ['Vorname'] = $vorname;
        $teiln ['Nachname'] = $nachname;
        $teiln ['Strasse'] = $strasse;
        $teiln ['Hausnummer'] = $hausnummer;
        $teiln ['PLZ'] = $ort;
        $teiln ['Ort'] = $database->fetchOrt($ort)["Ort"];
        $teiln ['Telefon'] = $telefon;
        $teiln ['Mail'] = $mail;

        $teilnehmer = teilnehmer::newTeilnehmer($teiln);

        return $teilnehmer;

    }

    public function existsTeilnehmer($teilnehmerID){

        /* @var database $database*/
        $database = database::getDatabase();
        $link = $database->getLink();

        $query = "SELECT TeilnehmerID, Nachname FROM teilnehmer WHERE TeilnehmerID = ?";

        $stmt = $link->prepare($query);
        $stmt->bind_param('i', $teilnehmerID);

        $stmt->execute();

        $stmt->bind_result($teilnehmerID, $nachname);

        $enthalten = false;

        while($stmt->fetch()){

            $enthalten = true;
            break;

        }
        $stmt->close();
        return $enthalten;
    }

    public function insertOrt($plz, $ort){

        /* @var database $database */
        $database = database::getDatabase();
        $link = $database->getLink();

        if (!$this->existsOrt($plz)) {

            $query = "INSERT INTO ort (PLZ, Ortname) VALUES (?, ?)";

            $stmt = $link->prepare($query);
            $stmt->bind_param('is', $plz, $ort);

        }

        else{

            $query = "UPDATE ort SET Ortname = ? WHERE PLZ = ?";

            $stmt = $link->prepare($query);
            $stmt->bind_param('si', $ort, $plz);

        }

        if($stmt->execute()) {

            $stmt->close();
            return true;

        }

        else {

            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            $stmt->close();
            return false;

        }

    }

    public function fetchOrt($plz){

        /* @var database $database*/
        $database = database::getDatabase();
        $link = $database->getLink();

        $query = "SELECT * FROM ort WHERE PLZ = ?";
        $stmt = $link->prepare($query);
        if ( false===$stmt ) {

            die('prepare() failed: ' . htmlspecialchars($link->error));
        }
        $stmt->bind_param('i', $plz);

        $stmt->execute();

        $stmt->bind_result($plz, $ort);
        $stmt->fetch();
        $stmt->close();

        $o["PLZ"] = $plz;
        $o["Ort"] = $ort;

        return $o;

    }

    public function existsOrt($plz){

        /* @var database $database*/
        $database = database::getDatabase();
        $link = $database->getLink();

        $query = "SELECT PLZ FROM ort WHERE PLZ = ?";
        $stmt = $link->prepare($query);
        $stmt->bind_param('i', $plz);

        $stmt->execute();

        $stmt->bind_result($plz);

        $enthalten = false;

        while($stmt->fetch()){

            $enthalten = true;
            break;

        }
        $stmt->close();
        return $enthalten;

    }

    public function insertReservation($reiseID, $teilnehmerID, $bezahlt){

        /* @var database $database*/
        $database = database::getDatabase();
        $link = $database->getLink();

        $query = "INSERT INTO reservation (ReiseID, TeilnehmerID, bezahlt) VALUES (?, ?, ?)";
        $stmt = $link->prepare($query);
        $stmt->bind_param('iii', $reiseID, $teilnehmerID, $bezahlt);

        if($stmt->execute()){

            $stmt->close();
            return true;

        }
        else {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            $stmt->close();
            return false;
        }
    }

    public function fetchReservation($reiseID, $teilnehmerID){

        /* @var database $database*/
        $database = database::getDatabase();
        $link = $database->getLink();

        $query = "SELECT * FROM reservation WHERE ReiseID = ? AND TeilnehmerID = ?";

        $stmt = $link->prepare($query);
        $stmt->bind_param('ii', $reiseID, $teilnehmerID);

        $stmt->execute();

        $stmt->bind_result($reiseID, $teilnehmerID, $bezahlt);
        $stmt->fetch();
        $stmt->close();

        $res["ReiseID"] = $reiseID;
        $res["TeilnehmerID"] = $teilnehmerID;
        $res["bezahlt"] = $bezahlt;

        return $res;
    }

    public function verifyLogin($user, $pwdhash){

        /* @var database $database*/
        $database = database::getDatabase();
        $link = $database->getLink();

        $query = "SELECT * FROM logindaten WHERE LoginID = ? AND Loghash = ?";
        $stmt = $link->prepare($query);
        $stmt->bind_param('is', $user, $pwdhash);
        $stmt->execute();
        $stmt->store_result();

        $result = $stmt->num_rows;

        return $result;
    }

    public function insertUser($user, $pwhash) {

        /* @var database $database*/
        $database = database::getDatabase();
        $link = $database->getLink();

        $query = "INSERT INTO logindaten VALUES (?, ?)";
        $stmt = $link->prepare($query);
        $stmt->bind_param('is', $user, $pwhash);

        if($stmt->execute()){

            $stmt->close();
            return true;

        }
        else {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            $stmt->close();
            return false;
        }

    }

    public function generateReport($type) {

        /* @var database $database*/
        $database = database::getDatabase();
        $link = $database->getLink();

        switch ($type) {

            case "Kreditoren":
                $query = "";
                break;
            case "Reiseteilnehmer":
                $query = "SELECT R.ReiseID, R.Ziel, R.Hinreise, T.Vorname, T.Nachname, O.PLZ, O.Ortname FROM Teilnehmer T JOIN Reservation Re ON T.TeilnehmerID=Re.TeilnehmerID JOIN Reise R ON Re.ReiseID=R.ReiseID JOIN Ort O ON T.Ort=O.PLZ ORDER BY R.ReiseID ASC";
                break;
            case "Debitoren":
                $query = "SELECT T.Nachname, T.Vorname, R.Ziel, R.Hinreise FROM Teilnehmer T JOIN Reservation Re ON T.TeilnehmerID=Re.TeilnehmerID JOIN Reise R ON Re.ReiseID=R.ReiseID WHERE Re.bezahlt = 0";
                break;
            case "Kundenuebersicht":
                $query = "SELECT T.TeilnehmerID, T.Vorname, T.Nachname, T.Strasse, T.Hausnummer, O.PLZ, O.Ortname, T.Telefon, T.Mail FROM Teilnehmer T JOIN Ort O ON T.Ort= O.PLZ ORDER BY T.TeilnehmerID ASC";
                break;
            case "Reiseuebersicht":
                $query = "SELECT R.ReiseID, R.Ziel, R.Bezeichnung, R.Preis, R.Hinreise, R.Rueckreise FROM Reise R";
                break;
            case "Reisen demnaechst":
                $query = "SELECT R.Ziel, R.Hinreise, T.Nachname, T.Vorname FROM Reise R JOIN Reservation Re ON R.ReiseID=Re.ReiseID JOIN Teilnehmer T ON Re.TeilnehmerID=T.TeilnehmerID WHERE R.Hinreise > CURDATE()";
                break;
            case "Finanzuebersicht":
                $query = "";
                break;
            case "Reisegruppen":
                $query = "";
                break;
        }

        if (!empty($query)) {
            $result = $link->query($query);
            return $result;
        }
        else return false;
    }

    public function getLink()
    {
        return $this->link;
    }

    public function getHost()
    {
        return $this->host;
    }

    public function toString(){

        return $this->dbname;
    }

    public function getAllReisen(){

        /* @var database $database */
        $database = database::getDatabase();
        $link = $database->getLink();

        $query = "SELECT * FROM reise";
        $result = $link->query($query);

        return $result;
    }

    public function getNextReisen() {

        /* @var database $database */
        $database = database::getDatabase();
        $link = $database->getLink();

        $query = "SELECT R.Hinreise, R.Bezeichnung, R.Ziel FROM Reise R WHERE R.Hinreise < DATE_ADD(CURDATE(), INTERVAL 60 DAY) ORDER BY R.Hinreise ASC";
//        $query = "SELECT R.Hinreise, R.Ziel FROM Reise R WHERE CURDATE() < R.Hinreise AND R.Hinreise < DATE_ADD(CURDATE(), INTERVAL 60 DAY)";

        $result = $link->query($query);
        return $result;
    }

    public function getNextRechnungen() {

        /* @var database $database */
        $database = database::getDatabase();
        $link = $database->getLink();

        $query = "SELECT R.Faelligkeit, R.Kostenart, R.Betrag, R.Waehrung FROM Rechnung R WHERE R.Faelligkeit < DATE_ADD(CURDATE(), INTERVAL 60 DAY) AND R.bezahlt = 0 ORDER BY R.Faelligkeit ASC";

        $result = $link->query($query);
        return $result;
    }

    public function getAllRechnungen($reiseID = null){

        if(is_null($reiseID)){

            /* @var database $database */
            $database = database::getDatabase();
            $link = $database->getLink();

            $query = "SELECT * FROM rechnung";
            $result = $link->query($query);

            return $result;

        }

        else {

            /* @var database $database */
            $database = database::getDatabase();
            $link = $database->getLink();

            $query = "SELECT * FROM rechnung WHERE Reise = $reiseID";
            $result = $link->query($query);

            return $result;
        }
    }

    public function deleteRechnung($rechnungsID){

        /* @var database $database */
        $database = database::getDatabase();
        $link = $database->getLink();


        $query= "DELETE FROM rechnung WHERE RechnungsID = $rechnungsID";
        $result = $link->query($query);

        return $result;

    }

    public function deleteReise($reiseID){

        /* @var database $database */
        $database = database::getDatabase();
        $link = $database->getLink();


        $query= "DELETE FROM reise WHERE ReiseID = $reiseID";
        $result = $link->query($query);

        return $result;

    }

    public function deleteTeilnehmer($teilnehmerID){

        /* @var database $database */
        $database = database::getDatabase();
        $link = $database->getLink();


        $query= "DELETE FROM teilnehmer WHERE TeilnehmerID = $teilnehmerID";
        $result = $link->query($query);

        return $result;

    }
}