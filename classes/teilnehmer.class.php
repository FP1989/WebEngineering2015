<?php



class teilnehmer{

    private $teilnehmerID;
    private $vorname;
    private $nachname;
    private $strasse;
    private $hausnummer;
    private $plz;
    private $ort;

    private function __construct($teilnehmerdaten, $id){

        $this->teilnehmerID = $id;
        $this->vorname = $teilnehmerdaten['vorname'];
        $this->nachname = $teilnehmerdaten['nachname'];
        $this->strasse = $teilnehmerdaten['strasse'];
        if(array_key_exists('hausnummmer', $teilnehmerdaten)) $this->hausnummer = $teilnehmerdaten['hausnummer'];
        $this->plz = $teilnehmerdaten['plz'];
        $this->ort = $teilnehmerdaten['ort'];

    }

    public function newTeilnehmer($teilnehmerdaten){

        if(array_key_exists('$teilnehmerID', $teilnehmerdaten)) $id = $teilnehmerdaten['teilnehmerID'];

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

}