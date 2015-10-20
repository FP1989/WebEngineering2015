<?php

class beguenstigter{

    private $beguenstigterID;
    private $beguenstigterName;
    private $strasse;
    private $hausnummer;
    private $plz;
    private $ort;

    private function __construct($beguenstigterdaten, $id){

        $this->beguenstigterID = $id;
        $this->beguenstigterName = $beguenstigterdaten['beguenstigterName'];
        $this->strasse = $beguenstigterdaten['strasse'];
        if(array_key_exists('hausnummer', $beguenstigterdaten)) $this->hausnummer = $beguenstigterdaten['hausnummer'];
        $this->plz = $beguenstigterdaten['plz'];
        $this->ort = $beguenstigterdaten['ort'];

    }

    public function newBeguenstigter($beguenstigterdaten){

        if(array_key_exists('beguenstigterID', $beguenstigterdaten)) $id = $beguenstigterdaten['beguenstigterID'];

        else $id = 'DEFAULT';

        $beguenstigter = new Beguenstigter($beguenstigterdaten, $id);

        return $beguenstigter;

    }

    public function getBeguenstigterName(){

        return $this->beguenstigterName;

    }

    public function setBeguenstigterName($beguenstigterName){

        $this->beguenstigterName = $beguenstigterName;

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

    public function getBeguenstigterID(){

        return $this->beguenstigterID;

    }

}