<?php

class reise{

    private $reiseID;
    private $ziel;
    private $beschreibung;
    private $bezeichnung;
    private $preis;
    private $hinreise;
    private $rueckreise;
    private $maxAnzahl;
    private $minAnzahl;
    const MAX = 20;
    const MIN = 12;



   private function __construct($reisedaten, $id){
        $this->reiseID = $id;
        $this->ziel = $reisedaten['Ziel'];
        $this->beschreibung = $reisedaten['Beschreibung'];
        $this->bezeichnung= $reisedaten['Bezeichnung'];
        $this->preis = $reisedaten['Preis'];
        $this->hinreise = $reisedaten['Hinreise'];
        $this->rueckreise = $reisedaten['Rueckreise'];
        $this->maxAnzahl = $reisedaten['MaxAnzahl'];
        $this->minAnzahl = $reisedaten['MinAnzahl'];
    }

   public static function newReise($reisedaten){

       if(array_key_exists('ReiseID', $reisedaten)) $id = $reisedaten['ReiseID'];

       else $id = 'DEFAULT';

       $reise = new Reise($reisedaten, $id);

       return $reise;

}

    public function getZiel(){

        return $this->ziel;

    }

    public function setZiel($ziel){

        $this->ziel = $ziel;

    }

    public function getBeschreibung(){

        return $this->beschreibung;

    }

    public function setBeschreibung($beschreibung){

        $this->beschreibung = $beschreibung;

    }

    public function getPreis(){

        return $this->preis;

    }

    public function setPreis($preis){

        $this->preis = $preis;

    }

    public function getHinreise(){

        return $this->hinreise;

    }

    public function setHinreise($hinreise){

        $this->hinreise = $hinreise;

    }

    public function getRueckreise(){

        return $this->rueckreise;

    }

    public function setRueckreise($rueckreise){

        $this->rueckreise = $rueckreise;

    }

    public function getReiseID(){

        return $this->reiseID;

    }

    public function getBezeichnung(){

        return $this->bezeichnung;

    }

    public function setBezeichnung($bezeichnung){

        $this->bezeichnung = $bezeichnung;

    }

    public function getMaxAnzahl(){

        return $this->maxAnzahl;

    }

    public function setMaxAnzahl($maxAnzahl){

        $this->maxAnzahl = $maxAnzahl;

    }

    public function getMinAnzahl(){

        return $this->minAnzahl;

    }

    public function setMinAnzahl($minAnzahl){

        $this->minAnzahl = $minAnzahl;

    }


}