<?php

include_once("beguenstigter.class.php");
include_once("reise.class.php");
include_once("rechnung.class.php");
include_once("teilnehmer.class.php");

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
        $this->benutzer = 'starreisen';
        $this->passwort ='webengineering2015';
        $this->dbname = 'starreisen';
        $this->link = mysqli_connect($this->host, $this->benutzer, $this->passwort, $this->dbname);
        $this->link->set_charset("utf8");
    }

//    private function __construct(){
//
//        $this->host = '127.0.0.1';
//        $this->benutzer = 'root';
//        $this->passwort ='';
//        $this->dbname = 'reiseunternehmen';
//        $this->link = mysqli_connect($this->host, $this->benutzer, $this->passwort, $this->dbname);
//    }

    public static function getDatabase(){

        if (database::$database == null) database::$database = new Database();

        return database::$database;

    }

    public function insertBeguenstigter(Beguenstigter $Beguenstigter){

        $id = $Beguenstigter->getBeguenstigterID();
        $name = $Beguenstigter->getBeguenstigterName();
        $strasse = $Beguenstigter->getStrasse();
        $hausnummer = $Beguenstigter->getHausnummer();
        $ort = $Beguenstigter->getOrt();
        $plz = $Beguenstigter->getPlz();

        if(!$this->existsOrt($plz)) $this->insertOrt($plz, $ort);

        /**  @var database $database */
        $database = database::getDatabase();
        $link = $database->getLink();

        if($id == "DEFAULT"){

            $query = "INSERT INTO Beguenstigter (BeguenstigterName, Strasse, Hausnummer, Ort) VALUES (?, ?, ?, ?)";
            $stmt = $link->prepare($query);
            $stmt->bind_param('sssi', $name, $strasse, $hausnummer, $plz);

        }

        else {

            $query = "UPDATE Beguenstigter SET BeguenstigterName = ?, Strasse = ?, Hausnummer = ?, Ort = ?  WHERE BeguenstigterID = ?";
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

    public function fetchBeguenstigter($BeguenstigterID = null, $BeguenstigterName = null){

        /* @var database $database*/
        $database = database::getDatabase();
        $link = $database->getLink();

        if(is_null($BeguenstigterID)&& is_null($BeguenstigterName)) return false;

        else if(!is_null($BeguenstigterID)) {

            $query = "SELECT * FROM Beguenstigter WHERE BeguenstigterID = ?";
            $stmt = $link->prepare($query);
            $stmt->bind_param('i',$BeguenstigterID);

        }

        else {

            $query = "SELECT * FROM Beguenstigter WHERE BeguenstigterName = ?";
            $stmt = $link->prepare($query);
            $stmt->bind_param('s',$BeguenstigterName);

        }

        $stmt->execute();
        $stmt->bind_result($BeguenstigterID, $BeguenstigterName, $strasse, $hausnummer, $ort);

        $stmt->fetch();
        $stmt->close();

        $beg["BeguenstigterID"] = $BeguenstigterID;
        $beg["BeguenstigterName"] = $BeguenstigterName;
        $beg["Strasse"] = $strasse;
        $beg["Hausnummer"] = $hausnummer;
        $beg["PLZ"] = $ort;
        $beg["Ort"] = $this->fetchOrt($ort)["Ort"];

        $Beguenstigter = Beguenstigter::newBeguenstigter($beg);

        return $Beguenstigter;

    }

    public function existsBeguenstigter($BeguenstigterID){

        /* @var database $database*/
        $database = database::getDatabase();
        $link = $database->getLink();

        $query = "SELECT BeguenstigterID, BeguenstigterName FROM Beguenstigter WHERE BeguenstigterID = ?";

        $stmt = $link->prepare($query);
        $stmt->bind_param('i', $BeguenstigterID);

        $stmt->execute();

        $stmt->bind_result($BeguenstigterID,$BeguenstigterName);

        $enthalten = false;

        while($stmt->fetch()){

            $enthalten = true;
            break;

        }

        $stmt->close();
        return $enthalten;

    }

    public function autosuggestBeguenstigter($term) {

        /* @var database $database*/
        $database = database::getDatabase();
        $link = $database->getLink();

        $term = "%".$term."%";

        $query = "SELECT BeguenstigterID, BeguenstigterName FROM Beguenstigter WHERE BeguenstigterName LIKE ?";
        $stmt = $link->prepare($query);
        $stmt->bind_param('s', $term);
        $stmt->execute();

        $stmt->bind_result($BegID, $BegName);

        $return = Array();

        while($stmt->fetch()) {

            $datensatz["BegID"] = $BegID;
            $datensatz["BegName"] = $BegName;
            $return [] = $datensatz;

        }
        $stmt->close();

        return $return;

    }

    public function insertReise(reise $reise){

        $id = $reise->getReiseID();
        $ziel = $reise->getZiel();
        $beschreibung = $reise->getBeschreibung();
        $bezeichnung = $reise->getBezeichnung();
        $preis = $reise->getPreis();
        $hinreise = $reise->getHinreise();
        $rueckreise = $reise->getRueckreise();
        $max = $reise->getMaxAnzahl();
        $min = $reise->getMinAnzahl();

        /** @var database $database*/
        $database = database::getDatabase();
        $link = $database->getLink();

        if($id == "DEFAULT") {

            $query = "INSERT INTO Reise (Ziel, Beschreibung, Bezeichnung, Preis, Hinreise, Rueckreise, MaximaleAnzahlTeilnehmer, MindestAnzahlTeilnehmer) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $link->prepare($query);
            $stmt->bind_param('sssdssii', $ziel,$beschreibung, $bezeichnung, $preis, $hinreise, $rueckreise, $max, $min);

        }

        else {

            $query = "UPDATE Reise SET Ziel = ?, Beschreibung = ?, Bezeichnung = ?, Preis = ?, Hinreise = ?, Rueckreise = ?, MaximaleAnzahlTeilnehmer = ?, MindestAnzahlTeilnehmer = ? WHERE ReiseID = ?";
            $stmt = $link->prepare($query);
            $stmt->bind_param('sssdssiii', $ziel, $beschreibung, $bezeichnung, $preis, $hinreise, $rueckreise, $max, $min, $id);

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

    public function fetchReise($reiseID = null, $reiseZiel = null){

        /* @var database $database*/
        $database = database::getDatabase();
        $link = $database->getLink();

        if(is_null($reiseID)&& is_null($reiseZiel)) return false;

        else if(!is_null($reiseID)) {

            $query = "SELECT * FROM Reise WHERE ReiseID = ?";
            $stmt = $link->prepare($query);
            $stmt->bind_param('i', $reiseID);

        }

        else {

            $query = "SELECT * FROM Reise WHERE Ziel = ?";
            $stmt = $link->prepare($query);
            $stmt->bind_param('s', $reiseZiel);

        }

        $stmt->execute();
        $stmt->bind_result($reiseID, $reiseZiel, $beschreibung, $bezeichnung, $preis, $hinreise, $rueckreise, $minAnzahl, $maxAnzahl);

        $stmt->fetch();
        $stmt->close();

        $rei["ReiseID"] = $reiseID;
        $rei["Ziel"] = $reiseZiel;
        $rei["Beschreibung"] = $beschreibung;
        $rei["Bezeichnung"] = $bezeichnung;
        $rei["Preis"] = $preis;
        $rei["Hinreise"] = $hinreise;
        $rei["Rueckreise"] = $rueckreise;
        $rei["MinAnzahl"] = $minAnzahl;
        $rei["MaxAnzahl"] = $maxAnzahl;

        $reise = reise::newReise($rei);

        return $reise;
    }

    public function existsReise($reiseID){

        /* @var database $database*/
        $database = database::getDatabase();
        $link = $database->getLink();

        $query = "SELECT ReiseID, Ziel FROM Reise WHERE ReiseID = ?";

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

    public function autosuggestReise($term) {

        /* @var database $database*/
        $database = database::getDatabase();
        $link = $database->getLink();

        $term = "%{$term}%";

        $query = "SELECT ReiseID, Bezeichnung FROM Reise WHERE Bezeichnung LIKE ?";
        $stmt = $link->prepare($query);
        $stmt->bind_param('s', $term);
        $stmt->execute();

        $stmt->bind_result($ReiseID, $ReiseBez);

        $return = Array();



        while($stmt->fetch()) {

            $datensatz["ReiseID"] = $ReiseID;
            $datensatz["ReiseBez"] = $ReiseBez;
            $return [] = $datensatz;

        }
        $stmt->close();

        return $return;

    }

    public function reportReisen() {

        /* @var database $database*/
        $database = database::getDatabase();
        $link = $database->getLink();

        $query = "SELECT Ziel, ReiseID FROM Reise";
        $result = $link->query($query);
        return $result;
    }

    public function insertRechnung(rechnung $rechnung){

        $id = $rechnung->getRechnungsID();
        $rechnungsart = $rechnung->getRechnungsart();
        $betrag = $rechnung->getBetrag();
        $iban = $rechnung->getIban();
        $swift = $rechnung->getSwift();
        $Beguenstigter = $rechnung->getBeguenstigter();
        $kostenart = $rechnung->getKostenart();
        $faelligkeit = $rechnung->getFaelligkeit();
        $bemerkung = $rechnung->getBemerkung();
        $reise = $rechnung->getReise();
        $bezahlt = $rechnung->isBezahlt();

        /** @var database $database */
        $database = database::getDatabase();
        $link = $database->getLink();

        if($id == "DEFAULT") {

            $query = "INSERT INTO Rechnung (Rechnungsart, Betrag, IBAN, SWIFT, Beguenstigter, Kostenart, Faelligkeit, Bemerkung, Reise, bezahlt) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $link->prepare($query);
            $stmt->bind_param('sdssisssii', $rechnungsart, $betrag, $iban, $swift, $Beguenstigter, $kostenart, $faelligkeit, $bemerkung, $reise, $bezahlt);

        }
        else {

            $query = "UPDATE Rechnung SET Rechnungsart = ?, Betrag = ?, IBAN = ?, SWIFT = ?, Beguenstigter = ?, Kostenart = ?, Faelligkeit = ?, Bemerkung = ?, Reise = ?, bezahlt = ? WHERE RechnungsID = ?";
            $stmt = $link->prepare($query);
            $stmt->bind_param('sdssisssiii', $rechnungsart, $betrag, $iban, $swift, $Beguenstigter, $kostenart, $faelligkeit, $bemerkung, $reise, $bezahlt, $id);

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

            $query = "SELECT * FROM Rechnung WHERE RechnungsID = ?";
            $stmt = $link->prepare($query);
            $stmt->bind_param('i', $rechnungsID);

        }

        else {

            $query = "SELECT * FROM Rechnung WHERE ReiseID = ?";
            $stmt = $link->prepare($query);
            $stmt->bind_param('i',$reiseID);

        }


        $stmt->execute();
        $stmt->bind_result($rechnungsID, $rechnungsart, $betrag, $iban, $swift, $Beguenstigter, $kostenart, $faelligkeit, $bemerkung, $reise, $bezahlt);
        $stmt->fetch();
        $stmt->close();

        $rg ["RechnungsID"] = $rechnungsID;
        $rg ["Rechnungsart"] = $rechnungsart;
        $rg ["Betrag"] = $betrag;
        $rg ["IBAN"] = $iban;
        $rg ["SWIFT"] = $swift;
        $rg ["Beguenstigter"] = $Beguenstigter;
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

        $query = "SELECT RechnungsID FROM Rechnung WHERE RechnungsID = ?";

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

            $query = "INSERT INTO Teilnehmer (Vorname, Nachname, Strasse, Hausnummer, Ort, Telefon, Mail) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $link->prepare($query);
            $stmt->bind_param('ssssiis', $vorname, $nachname, $strasse, $hausnummer, $plz, $telefon, $mail);

        }

        else {

            $query = "UPDATE Teilnehmer SET Vorname = ?, Nachname = ?, Strasse = ?, Hausnummer = ?, Ort = ?, Telefon = ?, Mail = ? WHERE TeilnehmerID = ?";
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

            $query = "SELECT * FROM Teilnehmer WHERE TeilnehmerID = ?";
            $stmt = $link->prepare($query);
            $stmt->bind_param('i', $teilnehmerID);

        }

        else {

            $query = "SELECT * FROM Teilnehmer WHERE Nachname = ?";
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

        $query = "SELECT TeilnehmerID, Nachname FROM Teilnehmer WHERE TeilnehmerID = ?";

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

    public function checkMultipleTeilnehmer($teilnehmer) {
        /* @var database $database*/
        $database = database::getDatabase();
        $link = $database->getLink();

        $query = "SELECT TeilnehmerID, Vorname, Nachname FROM Teilnehmer WHERE Nachname = ?";

        $stmt = $link->prepare($query);
        $stmt->bind_param('s', $teilnehmer);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($teilnehmerID, $vorname, $nachname);

        if($stmt->num_rows > 1) {

            $teilnehmer = array();
            $counter = 0;
            while ($stmt->fetch()) {

                $teilnehmer[$counter] = $teilnehmerID;
                $teilnehmer[$counter + 1] = $vorname;
                $teilnehmer[$counter + 2] = $nachname;

                $counter = $counter + 3;
            }
            $stmt->close();

            return $teilnehmer;
        } else return FALSE;

    }

    public function insertOrt($plz, $ort){

        /* @var database $database */
        $database = database::getDatabase();
        $link = $database->getLink();

        if (!$this->existsOrt($plz)) {

            $query = "INSERT INTO Ort (PLZ, Ortname) VALUES (?, ?)";

            $stmt = $link->prepare($query);
            $stmt->bind_param('is', $plz, $ort);

        }

        else{

            $query = "UPDATE Ort SET Ortname = ? WHERE PLZ = ?";

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

        $query = "SELECT * FROM Ort WHERE PLZ = ?";
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

        $query = "SELECT PLZ FROM Ort WHERE PLZ = ?";
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


        $query = "INSERT INTO Reservation (ReiseID, TeilnehmerID, bezahlt) VALUES (?, ?, ?)";
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

    public function fetchReservation($reiseID = null, $teilnehmerID = null){

        /* @var database $database*/
        $database = database::getDatabase();
        $link = $database->getLink();

        if(is_null($teilnehmerID) && is_null($reiseID)) return false;

        else if(is_null($reiseID)) {

            $query = "SELECT * FROM Reservation WHERE TeilnehmerID = ?";
            $stmt = $link->prepare($query);
            $stmt->bind_param('i', $teilnehmerID);


            $stmt->execute();

            $stmt->bind_result($reiseID, $teilnehmerID, $bezahlt);

            $return = Array();

            while($stmt->fetch()) {

                $datensatz["ReiseID"] = $reiseID;
                $datensatz["TeilnehmerID"] = $teilnehmerID;
                $datensatz["bezahlt"] = $bezahlt;

                $return [] = $datensatz;

            }
            $stmt->close();

            return $return;


        }

        else if(is_null($teilnehmerID)) {

            $query = "SELECT * FROM Reservation WHERE ReiseID = ?";
            $stmt = $link->prepare($query);
            $stmt->bind_param('i', $reiseID);


            $stmt->execute();

            $stmt->bind_result($reiseID, $teilnehmerID, $bezahlt);

            $return = Array();

            while($stmt->fetch()) {

                $datensatz["ReiseID"] = $reiseID;
                $datensatz["TeilnehmerID"] = $teilnehmerID;
                $datensatz["bezahlt"] = $bezahlt;

                $return [] = $datensatz;

            }
            $stmt->close();

            return $return;


        }

        else {


            $query = "SELECT * FROM Reservation WHERE ReiseID = ? AND TeilnehmerID = ?";

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
    }

    public function existsReservation($reiseID, $teilnehmerID){

        /* @var database $database*/
        $database = database::getDatabase();
        $link = $database->getLink();

        $query = "SELECT ReiseID, TeilnehmerID FROM Reservation WHERE ReiseID = ? AND TeilnehmerID = ?";

        $stmt = $link->prepare($query);
        $stmt->bind_param('ii', $reiseID, $teilnehmerID);
        $stmt->execute();
        $stmt->store_result();

        if($stmt->num_rows > 0) {
            $stmt->close();
            return TRUE;
        } else {
            $stmt->close();
            return FALSE;
        }
    }

    public function getID($id, $id_table){

        /* @var database $database*/
        $database = database::getDatabase();
        $link = $database->getLink();

        $query = "SELECT MAX($id) AS id FROM $id_table";
        $result = $link->query($query);
        return $result;

    }

    public function verifyLogin($user, $pwdhash){

        /* @var database $database*/
        $database = database::getDatabase();
        $link = $database->getLink();

        $query = "SELECT * FROM Logindaten WHERE LoginID = ? AND Loghash = ?";
        $stmt = $link->prepare($query);
        $stmt->bind_param('ss', $user, $pwdhash);
        $stmt->execute();
        $stmt->store_result();
        $result = $stmt->num_rows;
        $stmt->close();
        return $result;
    }

    public function insertPassword($user, $pwdhash) {

        /* @var database $database*/
        $database = database::getDatabase();
        $link = $database->getLink();

        $query = "UPDATE Logindaten SET Loghash = ? WHERE LoginID = ?";
        $stmt = $link->prepare($query);
        $stmt->bind_param('ss', $pwdhash, $user);

        if($stmt->execute()) {
            $stmt->close();
            return true;
        }

        else {
            $stmt->close();
            return false;
        }
    }

    public function getAllUsers() {

        /* @var database $database*/
        $database = database::getDatabase();
        $link = $database->getLink();

        $query = "SELECT ID, LoginID FROM Logindaten WHERE loginID != 'admin'";
        $result = $link->query($query);
        return $result;
    }

    public function existsUser($user) {
        /* @var database $database*/
        $database = database::getDatabase();
        $link = $database->getLink();

        $query = "SELECT * FROM Logindaten WHERE loginID = ?";
        $stmt = $link->prepare($query);
        $stmt->bind_param('s', $user);
        $stmt->execute();
        $stmt->store_result();
        $result = $stmt->num_rows;
        $stmt->close();
        return $result;
    }

    public function insertUser($user, $pwhash) {

        /* @var database $database*/
        $database = database::getDatabase();
        $link = $database->getLink();

        $query = "INSERT INTO Logindaten (LoginID, Loghash) VALUES (?, ?)";
        $stmt = $link->prepare($query);
        $stmt->bind_param('ss', $user, $pwhash);

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

    public function generateReport($type, $option = NULL) {

        /* @var database $database*/
        $database = database::getDatabase();
        $link = $database->getLink();

        switch ($type) {

            case "Kreditoren":
                $query = "SELECT Re.RechnungsID, Re.Rechnungsart, Re.Betrag AS Währung, Re.Kostenart, Re.Faelligkeit AS Fälligkeit FROM Rechnung Re WHERE Re.bezahlt = 0 ORDER BY Re.RechnungsID ASC";
                break;
            case "Reisebuchungen":
                $query = "SELECT R.ReiseID, R.Ziel, R.Bezeichnung, R.Hinreise, COUNT(DISTINCT T.TeilnehmerID) AS TotalTeilnehmer FROM Teilnehmer T JOIN Reservation Re ON T.TeilnehmerID = Re.TeilnehmerID JOIN Reise R ON Re.ReiseID = R.ReiseID GROUP BY R.Ziel ORDER BY TotalTeilnehmer DESC";
                break;
            case "Reiseteilnehmer":
                $query = "SELECT R.Ziel, R.Bezeichnung, R.Hinreise, T.Vorname, T.Nachname, O.PLZ, O.Ortname FROM Teilnehmer T JOIN Reservation Re ON T.TeilnehmerID=Re.TeilnehmerID JOIN Reise R ON Re.ReiseID=R.ReiseID JOIN Ort O ON T.Ort=O.PLZ WHERE R.ReiseID = $option ORDER BY R.ReiseID ASC";
                break;
            case "Debitoren":
                $query = "SELECT T.Nachname, T.Vorname, R.Ziel, R.Hinreise FROM Teilnehmer T JOIN Reservation Re ON T.TeilnehmerID=Re.TeilnehmerID JOIN Reise R ON Re.ReiseID=R.ReiseID WHERE Re.bezahlt = 0";
                break;
            case "Zuletzt erfasste Teilnehmer":
                $query = "SELECT T.TeilnehmerID, T.Vorname, T.Nachname, T.Strasse, O.Ortname FROM Teilnehmer T JOIN Ort O ON T.Ort = O.PLZ ORDER BY TeilnehmerID DESC LIMIT $option";
                break;
            case "Kundenadressen":
                $query = "SELECT T.TeilnehmerID, T.Vorname, T.Nachname, T.Strasse, T.Hausnummer, O.PLZ, O.Ortname FROM Teilnehmer T JOIN Ort O ON T.Ort= O.PLZ ORDER BY T.TeilnehmerID ASC";
                break;
            case "Kundenkontakt":
                $query = "SELECT T.TeilnehmerID, T.Vorname, T.Nachname, T.Telefon, T.Mail FROM Teilnehmer T ORDER BY T.TeilnehmerID ASC";
                break;
            case "Reiseübersicht":
                $query = "SELECT R.ReiseID, R.Ziel, R.Bezeichnung, R.Preis, R.Hinreise, R.Rueckreise FROM Reise R";
                break;
            case "Begünstigte":
                $query = "SELECT BeguenstigterID AS BegünstigterID, BeguenstigterName AS BegünstigterName, Strasse, Hausnummer, Ort FROM Beguenstigter";
                break;
            case "Finanzübersicht":


                $query = "
SELECT
R.ReiseID,
R.Ziel,
R.Hinreise,
A.Ausgaben,
E.Einnahmen,
(E.Einnahmen - A.Ausgaben) AS Gewinn

FROM (
SELECT Rg.Reise,
SUM(Rg.Betrag) AS Ausgaben
FROM Rechnung Rg
GROUP BY Rg.Reise) AS A

JOIN

(SELECT Rs.ReiseID,
(COUNT(RE.TeilnehmerID) * Rs.Preis) AS Einnahmen
FROM Reise Rs JOIN Reservation RE
ON Rs.ReiseID = RE.ReiseID
GROUP BY Rs.ReiseID) AS E

ON A.Reise = E.ReiseID

JOIN Reise R
ON R.ReiseID = A.Reise
GROUP BY R.ReiseID
ORDER BY Gewinn DESC;";
                break;
        }

        if (!empty($query)) {
            $result = $link->query($query);
            return $result;
        } else return FALSE;
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

    public function getAllReisen($timespan){

        /* @var database $database */
        $database = database::getDatabase();
        $link = $database->getLink();


        if(!is_numeric($timespan)) $query = "SELECT ReiseID, Ziel, Bezeichnung, Preis, Hinreise, Rueckreise  FROM Reise";
//
        else {

            $timespan = intval($timespan);
            $query = "SELECT ReiseID, Ziel, Bezeichnung, Preis, Hinreise, Rueckreise  FROM Reise WHERE Rueckreise >= CURDATE() - INTERVAL $timespan DAY";

        }

        $result = $link->query($query);

        return $result;
    }

    public function getNextReisen() {

        /* @var database $database */
        $database = database::getDatabase();
        $link = $database->getLink();

        $query = "SELECT R.Hinreise, R.Bezeichnung, R.Ziel FROM Reise R WHERE R.Hinreise < DATE_ADD(CURDATE(), INTERVAL 60 DAY) AND R.Hinreise > CURDATE() ORDER BY R.Hinreise ASC";

        $result = $link->query($query);
        return $result;
    }

    public function getNextRechnungen() {

        /* @var database $database */
        $database = database::getDatabase();
        $link = $database->getLink();

        $query = "SELECT R.Faelligkeit, R.Kostenart, R.Betrag FROM Rechnung R WHERE R.Faelligkeit > CURDATE() AND R.bezahlt = 0 ORDER BY R.Faelligkeit ASC";

        $result = $link->query($query);
        return $result;
    }

    public function getAllRechnungen($reiseID = null){

        if(is_null($reiseID)){

            /* @var database $database */
            $database = database::getDatabase();
            $link = $database->getLink();

            $query = "SELECT * FROM Rechnung";
            $result = $link->query($query);

            return $result;

        }

        else {

            /* @var database $database */
            $database = database::getDatabase();
            $link = $database->getLink();

            $query = "SELECT * FROM Rechnung WHERE Reise = $reiseID";
            $result = $link->query($query);

            return $result;
        }
    }

    public function deleteRechnung($rechnungsID){

        /* @var database $database */
        $database = database::getDatabase();
        $link = $database->getLink();

        $query= "DELETE FROM Rechnung WHERE RechnungsID = ?";
        $stmt = $link->prepare($query);
        $stmt->bind_param('i', $rechnungsID);

        if($stmt->execute()){

            $stmt->close();
            return true;

        }
        else {

            $stmt->close();
            return false;
        }
    }

    public function deleteReise($reiseID){

        /* @var database $database */
        $database = database::getDatabase();
        $link = $database->getLink();

        $allowed = true;

        $queryRes = "SELECT * FROM Reservation WHERE ReiseID = $reiseID";
        $result = $link->query($queryRes);

        if($result->num_rows>0) $allowed =  false;

        $queryRes = "SELECT * FROM Rechnung WHERE Reise = $reiseID";
        $result = $link->query($queryRes);

        if($result->num_rows>0) $allowed =  false;


        if(!$allowed) return false;

        else {

            $query = "DELETE FROM Reise WHERE ReiseID = ?";
            $stmt = $link->prepare($query);
            $stmt->bind_param('i', $reiseID);

            if ($stmt->execute()) {

                $stmt->close();
                return true;

            } else {

                $stmt->close();
                return false;
            }
        }
    }

    public function deleteTeilnehmer($teilnehmerID){

        /* @var database $database */
        $database = database::getDatabase();
        $link = $database->getLink();

        $queryRes = "SELECT * FROM Reservation WHERE TeilnehmerID = $teilnehmerID";
        $result = $link->query($queryRes);

        if($result->num_rows>0) return false;

        else{

            $query= "DELETE FROM Teilnehmer WHERE TeilnehmerID = ?";
            $stmt = $link->prepare($query);
            $stmt->bind_param('i', $teilnehmerID);

            if($stmt->execute()){

                $stmt->close();
                return true;

            }
            else {

                $stmt->close();
                return false;
            }
        }
    }

    public function deleteUser($userID){

        /* @var database $database */
        $database = database::getDatabase();
        $link = $database->getLink();

        $query = "DELETE FROM Logindaten WHERE ID = ?";
        $stmt = $link->prepare($query);
        $stmt->bind_param('i', $userID);

        if($stmt->execute()){

            $stmt->close();
            return true;

        }
        else {

            $stmt->close();
            return false;
        }
    }

    public function deleteBeguenstigter($begID){

        /* @var database $database */
        $database = database::getDatabase();
        $link = $database->getLink();

        $queryRe = "SELECT * FROM Rechnung WHERE Beguenstigter = $begID";
        $result = $link->query($queryRe);

        if($result->num_rows>0) return false;

        else{

            $query = "DELETE FROM Beguenstigter WHERE BeguenstigterID = ?";
            $stmt = $link->prepare($query);
            $stmt->bind_param('i', $begID);

            if($stmt->execute()){

                $stmt->close();
                return true;

            }
            else {

                $stmt->close();
                return false;
            }
        }
    }

    public function deleteReservation($teilnehmerID, $reiseID){

        /* @var database $database */
        $database = database::getDatabase();
        $link = $database->getLink();

        $query = "DELETE FROM Reservation WHERE ReiseID = ? and TeilnehmerID = ?";
        $stmt = $link->prepare($query);
        $stmt->bind_param('ii', $reiseID, $teilnehmerID);

        if($stmt->execute()){

            $stmt->close();
            return true;

        }
        else {

            $stmt->close();
            return false;
        }
    }

    public function getAnzahlTeilnehmer($reiseID){

        /* @var database $database */
        $database = database::getDatabase();
        $link = $database->getLink();

        $query = "SELECT COUNT(TeilnehmerID) FROM Reservation WHERE ReiseID = ?";
        $stmt = $link->prepare($query);
        $stmt->bind_param('i', $reiseID);

        $stmt->execute();
        $stmt->bind_result($anzahl);
        $stmt->fetch();
        $stmt->close();

        return $anzahl;

    }

    public function setBezahlt($teilnehmerID, $reiseID){

        /* @var database $database */
        $database = database::getDatabase();
        $link = $database->getLink();

        $query = "UPDATE Reservation SET bezahlt = 1 WHERE ReiseID = ? and TeilnehmerID = ?";
        $stmt = $link->prepare($query);
        $stmt->bind_param('ii', $reiseID, $teilnehmerID);

        if($stmt->execute()){

            $stmt->close();
            return true;

        }
        else {

            $stmt->close();
            return false;
        }
    }

    public function existingReservation($reiseID, $teilnehmerID){

        /* @var database $database */
        $database = database::getDatabase();
        $link = $database->getLink();

        $query = "SELECT COUNT(TeilnehmerID) FROM Reservation WHERE ReiseID = ? AND TeilnehmerID = ?";
        $stmt = $link->prepare($query);
        $stmt->bind_param('ii', $reiseID, $teilnehmerID);

        $stmt->execute();
        $stmt->bind_result($anzahl);
        $stmt->fetch();
        $stmt->close();

        if($anzahl == 1) return true;
        else return false;

    }

    public function getMaxAnzahlTeilnehmer($reiseID){

        /* @var database $database */
        $database = database::getDatabase();
        $link = $database->getLink();

        $query = "SELECT MaximaleAnzahlTeilnehmer FROM Reise WHERE ReiseID = ?";
        $stmt = $link->prepare($query);
        $stmt->bind_param('i', $reiseID);

        $stmt->execute();
        $stmt->bind_result($anzahl);
        $stmt->fetch();
        $stmt->close();

        return $anzahl;

    }

    public function getMinAnzahlTeilnehmer($reiseID){

        /* @var database $database */
        $database = database::getDatabase();
        $link = $database->getLink();

        $query = "SELECT MindestAnzahlTeilnehmer FROM Reise WHERE ReiseID = ?";
        $stmt = $link->prepare($query);
        $stmt->bind_param('i', $reiseID);

        $stmt->execute();
        $stmt->bind_result($anzahl);
        $stmt->fetch();
        $stmt->close();

        return $anzahl;
    }
}