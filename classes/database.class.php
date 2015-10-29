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

        $id = $beguenstigter->getBeguenstigterID();
        $name = $beguenstigter->getBeguenstigterName();
        $strasse = $beguenstigter->getStrasse();
        $hausnummer = $beguenstigter->getHausnummer();
        $ort = $beguenstigter->getOrt();
        $plz = $beguenstigter->getPlz();

        if(!$this->fetchOrt($plz)) $this->insertOrt($plz, $ort);

        if($id == "DEFAULT")$query = "INSERT INTO beguenstigter VALUES ('$id', '$name', '$strasse', '$hausnummer', '$plz')";
        else $query = "UPDATE beguenstigter SET BeguenstigterName = $name, Strasse = $strasse, Hausnummer = $hausnummer, Ort = $plz  WHERE BeguenstigterID = $id";

        if(mysqli_query($this->link, $query)) return true;
        else return false;

    }

    public function fetchBeguenstigter($beguenstigterID = null, $beguenstigterName = null){

        if(is_null($beguenstigterID)&& is_null($beguenstigterName)) return false;
        else if(!is_null($beguenstigterID)) $query = "SELECT * FROM beguenstigter WHERE BeguenstigterID = '$beguenstigterID'";
        else $query = "SELECT * FROM beguenstigter WHERE BeguenstigterName = '$beguenstigterName'";

        $result = $this->link->query($query);

        $datensatz = $result->fetch_assoc();

        if(is_null($datensatz)) return false;

        else {
            $beguenstigter = Beguenstigter::newBeguenstigter($datensatz);

            return $beguenstigter;
        }

    }

    public function insertReise(reise $reise){

        $id = $reise->getReiseID();
        $ziel = $reise->getZiel();
        $beschreibung = $reise->getBeschreibung();
        $bezeichnung = $reise->getBezeichnung();
        $preis = $reise->getPreis();
        $hinreise = $reise->getHinreise();
        $rueckreise = $reise->getRueckreise();

        if($id == "DEFAULT") $query = "INSERT INTO reise VALUES ('$id', '$ziel', '$beschreibung', '$bezeichnung', '$preis', '$hinreise', '$rueckreise')";
        else $query = "UPDATE reise SET Ziel = $ziel, Beschreibung = $beschreibung, Bezeichnung = $bezeichnung, Preise = $preis, Hinreise = $hinreise, Rueckreise = $rueckreise WHERE ReiseID = $id";

        if(mysqli_query($this->link, $query)) return true;
        else return false;

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

        if(!$this->fetchBeguenstigter($beguenstigter->getBeguenstigterID)) $this->insertBeguenstigter($beguenstigter);

        if($id == "DEFAULT") $query = "INSERT INTO rechnung VALUES ('$id', '$rechnungsart', '$betrag', '$waehrung', '$iban', '$swift', '$beguenstigter', '$kostenart', '$faelligkeit', '$bemerkung', '$reise', '$bezahlt')";
        else $query = "UPDATE Rechnung SET Rechnungsart = $rechnungsart, Betrag = $betrag, Waehrung = $waehrung, IBAN = $iban, SWIFT = $swift, Beguenstigter = $beguenstigter, Kostenart = $kostenart, Faelligkeit = $faelligkeit, Bemerkung = $bemerkung, Reise = $reise, bezahlt = $bezahlt";

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

        if($id == "DEFAULT") $query = "INSERT INTO teilnehmer VALUES ('$id', '$vorname', '$nachname', '$strasse', '$hausnummer', '$plz', '$telefon', '$mail')";
        else $query = "UPDATE teilnehmer SET TeilnehmerID = $id, Vorname = $vorname, Nachname = $nachname, Strasse = $strasse, Hausnummer = $hausnummer, Ort = $plz, Telefon = $telefon, Mail = $mail";

        if(mysqli_query($this->link, $query)) return true;
        else return false;

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







}