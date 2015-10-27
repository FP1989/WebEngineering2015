<?php

class reise{

private $reiseID;
private $ziel;
private $beschreibung;
private $bezeichnung;
private $preis;
private $hinreise;
private $rueckreise;

   private function __construct($reisedaten, $id){

        $this->reiseID = $id;
        $this->ziel = $reisedaten['ziel'];
        $this->beschreibung = $reisedaten['beschreibung'];
        $this->preis = $reisedaten['preis'];
        $this->hinreise = $reisedaten['hinreise'];
        $this->rueckreise = $reisedaten['rueckreise'];
    }

   public function newReise($reisedaten){

       if(array_key_exists('reiseID', $reisedaten)) $id = $reisedaten['reiseID'];

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

}