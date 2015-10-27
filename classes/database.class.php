<?php

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

    public static function createDatabase(){

    if (database::$database == null) database::$database = new Database();

    return database::$database;

    }

    public function insertBeguenstigter(beguenstigter $beguenstigter){

        $name = $beguenstigter->getBeguenstigterName();
        $strasse = $beguenstigter->getStrasse();
        $hausnummer = $beguenstigter->getHausnummer();
        $ort = $beguenstigter->getOrt();
        $plz = $beguenstigter->getPlz();

        if(!$this->fetchOrt($plz)) $this->insertOrt($plz, $ort);

        $query = "INSERT INTO beguenstigter VALUES ('DEFAULT', '$name', '$strasse', '$hausnummer', '$plz')";

        if(mysqli_query($this->link, $query)) return true;
        else return false;

    }

    public function fetchBeguenstigter($beguenstigterID){

        $query = "SELECT * FROM beguenstigter WHERE beguenstigterID = '$beguenstigterID'";

        $result = $this->link->query($query);

        $datensatz = $result->fetch_assoc();

        if(is_null($datensatz)) return false;

        else {
            $beguenstigter = Beguenstigter::newBeguenstigter($datensatz);

            return $beguenstigter;
        }

    }

    public function alterBeguenstigter($beguenstigter){}

    public function insertReise(reise $reise){

        $ziel = $reise->getZiel();
        $beschreibung = $reise->getBeschreibung();
        $bezeichnung = $reise->getBezeichnung();
        $preis = $reise->getPreis();
        $hinreise = $reise->getHinreise();
        $rueckreise = $reise->getRueckreise();

        $query = "INSERT INTO reise VALUES ('DEFAULT', '$ziel', '$beschreibung', '$bezeichnung', '$preis', '$hinreise', '$rueckreise')";

        if(mysqli_query($this->link, $query)) return true;
        else return false;

    }

    public function fetchReise($reiseID){

        $query = "SELECT * FROM reise WHERE reiseID = '$reiseID'";

        $result = $this->link->query($query);

        $datensatz = $result->fetch_assoc();

        if(is_null($datensatz)) return false;

        else {
            $reise = reise::newReise($datensatz);

            return $reise;
        }
    }

    public function alterReise($reise){}

    public function insertRechnung(rechnung $rechnung){

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

        if(!$this->fetchBeguenstigter($beguenstigter->getBeguenstigterID)) $this->insertBeguenstigter($beguenstigter);

        $query = "INSERT INTO rechnung VALUES ('DEFAULT', '$rechnungsart', '$betrag', '$waehrung', '$iban', '$swift', '$beguenstigter', '$kostenart', '$faelligkeit', '$bemerkung', '$reise', '$bezahlt')";

        if(mysqli_query($this->link, $query)) return true;
        else return false;

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

    public function alterRechnung($rechnungsID){}

    public function insertTeilnehmner(teilnehmer $teilnehmer){

        $vorname = $teilnehmer->getVorname();
        $nachname = $teilnehmer->getNachname();
        $strasse = $teilnehmer->getStrasse();
        $hausnummer = $teilnehmer->getHausnummer();
        $plz = $teilnehmer->getPlz();
        $ort = $teilnehmer->getOrt();
        $telefon = $teilnehmer->getTelefonNr();
        $mail = $teilnehmer->getEmail();

        if(!$this->fetchOrt($plz)) $this->insertOrt($plz, $ort);

        $query = "INSERT INTO teilnehmer VALUES ('DEFAULT', '$vorname', '$nachname', '$strasse', '$hausnummer', '$plz', '$telefon', '$mail')";

        if(mysqli_query($this->link, $query)) return true;
        else return false;

    }

    public function fetchTeilnehmer($teilnehmerID){

        $query = "SELECT * FROM teilnehmer WHERE teilnehmerID = '$teilnehmerID'";

        $result = $this->link->query($query);

        $datensatz = $result->fetch_assoc();

        if(is_null($datensatz)) return false;

        else {
            $teilnehmer = teilnehmer::newTeilnehmer($datensatz);

            return $teilnehmer;
        }

    }

    public function alterTeilnehmer($teilnehmer){}

    public function insertOrt($plz, $ort){

        $query = "INSERT INTO ort VALUES ('$plz', '$ort')";

        if(mysqli_query($this->link, $query)) return true;
        else return false;

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

        $query = "INSERT INTO reservation VALUES ('$reiseID', '$teilnehmerID', '$bezahlt')";

        if(mysqli_query($this->link, $query)) return true;
        else return false;

    }

    public function fetchReservation($reiseID, $teilnehmerID){

        $query = "SELECT * FROM reservation WHERE reiseID = '$reiseID' AND teilnehmerID = '$teilnehmerID'";

        $result = $this->link->query($query);

        $datensatz = $result->fetch_assoc();

        if(is_null($datensatz)) return false;

        else return $datensatz;

    }

    public function alterReservation($reiseID, $teilnehmerID){}

    public function verifyLogin($user, $pwdhash){

        $query = "SELECT * FROM logindaten WHERE LoginID = '$user' AND Loghash = '$pwdhash'";

        $result = $this->link->query($query);

        return $result;

    }







}