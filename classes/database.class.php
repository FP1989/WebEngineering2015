<?php

include ("beguenstigter.class.php");

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

        if(!$this->fetchOrt($plz)) $this->insertOrt($plz, $ort);

        /**  @var database $database */
        $database = database::getDatabase();
        $link = $database->getLink();

        if($id == "DEFAULT"){

            $query = "INSERT INTO beguenstigter (BeguenstigterName, Strasse, Hausnummer, Ort) VALUES (?, ?, ?, ?, ?)";
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

        if(is_null($beguenstigterID)&& is_null($beguenstigterName)) return false;
        else if(!is_null($beguenstigterID)) $query = "SELECT * FROM beguenstigter WHERE BeguenstigterID = '$beguenstigterID'";
        else $query = "SELECT * FROM beguenstigter WHERE BeguenstigterName = '$beguenstigterName'";

        $result = $this->link->query($query);

        $datensatz = $result->fetch_assoc();

        if(is_null($datensatz)) return false;

        else {


            $beguenstigter = beguenstigter::newBeguenstigter($datensatz);
            return $beguenstigter;

        }

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

        if(is_null($reiseID)&& is_null($reiseZiel)) return false;
        else if(!is_null($reiseID)) $query = "SELECT * FROM reise WHERE ReiseID = '$reiseID'";
        else $query = "SELECT * FROM reise WHERE Ziel = '$reiseZiel'";

        $result = $this->link->query($query);

        $datensatz = $result->fetch_assoc();

        if(is_null($datensatz)) return false;

        else {
            $reise = reise::newReise($datensatz);

            return $reise;
        }
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

        if(!$this->existsBeguenstigter($beguenstigter)) return false;//$this->insertBeguenstigter($beguenstigter);

        /** @var database $database*/
        $database = database::getDatabase();
        $link = $database->getLink();

        if($id == "DEFAULT") {

            $query = "INSERT INTO rechnung (Rechnungsart, Betrag, Waehrung, IBAN, SWIFT, Beguenstigter, Kostenart, Faelligkeit, Bemerkung, Reise, bezahlt) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $link->prepare($query);
            $stmt->bind_param('sdsssisssii', $rechnungsart, $betrag, $waehrung, $iban, $swift, $beguenstigter, $kostenart, $faelligkeit, $bemerkung, $reise, $bezahlt);

        }
        else {

            $query = "UPDATE Rechnung SET Rechnungsart = ?, Betrag = ?, Waehrung = ?, IBAN = ?, SWIFT = ?, Beguenstigter = ?, Kostenart = ?, Faelligkeit = ?, Bemerkung = ?, Reise = ?, bezahlt = ? WHERE BeguenstigterID = ?";
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

    public function fetchRechnung($rechnungsID){

        $query = "SELECT * FROM rechnung WHERE rechnunsID = '$rechnungsID'";

        $result = $this->link->query($query);

        $datensatz = $result->fetch_assoc();

        if(is_null($datensatz)) return false;

        else {
            $rechnung = rechnung::newRechnung($datensatz);

            return $rechnung;
        }

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

        if(!$this->fetchOrt($plz)) $this->insertOrt($plz, $ort);

        /** @var database $database*/
        $database = database::getDatabase();
        $link = $database->getLink();

        if($id == "DEFAULT") {

            $query = "INSERT INTO teilnehmer (Vorname, Nachname, Strasse, Hausnummer, Ort, Telefon, Mail) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
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

        if(is_null($teilnehmerID) && is_null($teilnehmerName)) return false;
        else if(!is_null($teilnehmerID)) $query = "SELECT * FROM teilnehmer WHERE TeilnehmerID = '$teilnehmerID'";
        else $query = "SELECT * FROM teilnehmer WHERE Nachname = '$teilnehmerName'";

        $result = $this->link->query($query);

        $datensatz = $result->fetch_assoc();

        if(is_null($datensatz)) return false;

        else {
            $teilnehmer = teilnehmer::newTeilnehmer($datensatz);

            return $teilnehmer;
        }

    }

    public function insertOrt($plz, $ort){

        /* @var database $database*/
        $database = database::getDatabase();
        $link = $database->getLink();

        $query = "INSERT INTO ort (PLZ, Ortname)VALUES (?, ?)";
        $stmt = $link->prepare($query);
        $stmt->bind_param('is', $plz, $ort);

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

        $query = "SELECT * FROM ort WHERE plz = '$plz'";

        $result = $this->link->query($query);

        $datensatz = $result->fetch_assoc();

        if(is_null($datensatz)) return false;

        else return $datensatz;

    }

    public function alterOrt($ort){}

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
        else{

            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            $stmt->close();
            return false;

        }

    }

    public function fetchReservation($reiseID, $teilnehmerID){

        $query = "SELECT * FROM reservation WHERE ReiseID = '$reiseID' AND TeilnehmerID = '$teilnehmerID'";

        $result = $this->link->query($query);

        $datensatz = $result->fetch_assoc();

        if(is_null($datensatz)) return false;

        else return $datensatz;

    }

    public function verifyLogin($user, $pwdhash){

        $query = "SELECT * FROM logindaten WHERE LoginID = '$user' AND Loghash = '$pwdhash'";

        $result = $this->link->query($query);

        return $result;

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






}