<?php



class teilnehmer{

    private $teilnehmerID;
    private $vorname;
    private $nachname;
    private $strasse;
    private $hausnummer;
    private $plz;
    private $ort;
    private $telefonNr;
    private $email;

    private function __construct($teilnehmerdaten, $id){

        $this->teilnehmerID = $id;
        $this->vorname = $teilnehmerdaten['Vorname'];
        $this->nachname = $teilnehmerdaten['Nachname'];
        $this->strasse = $teilnehmerdaten['Strasse'];
        if(array_key_exists('Hausnummer', $teilnehmerdaten)) $this->hausnummer = $teilnehmerdaten['Hausnummer'];
        $this->plz = $teilnehmerdaten['PLZ'];
        $this->ort = $teilnehmerdaten['Ort'];
        if(array_key_exists('Telefon', $teilnehmerdaten)) $this->telefonNr = $teilnehmerdaten['Telefon'];
        if(array_key_exists('Mail', $teilnehmerdaten)) $this->email = $teilnehmerdaten['Mail'];

    }

    public static function newTeilnehmer($teilnehmerdaten){

        if(array_key_exists('$teilnehmerID', $teilnehmerdaten)) $id = $teilnehmerdaten['TeilnehmerID'];

        else $id = 'DEFAULT';

        $teilnehmer = new Teilnehmer($teilnehmerdaten, $id);

        return $teilnehmer;

    }

    public function getVorname(){

        return $this->vorname;

    }

    public function setVorname($vorname){

        $this->vorname = $vorname;

    }

    public function getNachname(){

        return $this->nachname;

    }

    public function setNachname($nachname){

        $this->nachname = $nachname;

    }

    public function getStrasse(){

        return $this->strasse;

    }

    public function setStrasse($strasse){

        $this->strasse = $strasse;

    }

    public function getHausnummer(){

        return $this->hausnummer;

    }

    public function setHausnummer($hausnummer){

        $this->hausnummer = $hausnummer;

    }

    public function getEmail(){

        return $this->email;

    }

    public function setEmail($email){

        $this->email = $email;

    }

    public function getPlz(){

        return $this->plz;

    }

    public function setPlz($plz){

        $this->plz = $plz;

    }

    public function getOrt(){

        return $this->ort;

    }

    public function setOrt($ort){

        $this->ort = $ort;

    }

    public function getTeilnehmerID(){

        return $this->teilnehmerID;

    }


    public function getTelefonNr(){

        return $this->telefonNr;

    }

    public function setTelefonNr($telefonNr){

        $this->telefonNr = $telefonNr;

    }

}