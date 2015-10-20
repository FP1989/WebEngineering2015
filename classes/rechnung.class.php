<?php

class rechnung{

    private $rechnungsID;
    private $rechnungsart;
    private $betrag;
    private $waehrung;
    private $iban;
    private $swift;
    private $beguenstigter;
    private $kostenart;
    private $faelligkeit;
    private $bemerkung;
    private $reise;
    private $bezahlt;


    private function __construct($rechnungsdaten, $id){

        $this->rechnungsID = $id;
        $this->rechnungsart = $rechnungsdaten['rechnungsart'];
        $this->betrag = $rechnungsdaten['betrag'];
        $this->waehrung = $rechnungsdaten['waehrung'];
        $this->iban = $rechnungsdaten['iban'];
        if(array_key_exists('swift', $rechnungsdaten)) $this->swift = $rechnungsdaten['swift'];
        $this->beguenstigter = $rechnungsdaten['beguenstigter'];
        $this->kostenart = $rechnungsdaten['kostenart'];
        $this->faelligkeit = $rechnungsdaten['faelligkeit'];
        if(array_key_exists('bemerkung', $rechnungsdaten)) $this->bemerkung = $rechnungsdaten['bemerkung'];
        if(array_key_exists('reise',$rechnungsdaten)) $this->reise = $rechnungsdaten['reise'];
        $this->bezahlt = $rechnungsdaten['bezahlt'];
    }

    public function newRechnung($rechnungsdaten){

        if(array_key_exists('rechnungsID', $rechnungsdaten)) $id = $rechnungsdaten['rechnungsID'];

        else $id = 'DEFAULT';

        $rechnung = new Rechnung($rechnungsdaten, $id);

        return $rechnung;

    }

    public function getRechnungsart(){

        return $this->rechnungsart;

    }

    public function setRechnungsart($rechnungsart){

        $this->rechnungsart = $rechnungsart;

    }

    public function getBetrag(){

        return $this->betrag;

    }

    public function setBetrag($betrag){

        $this->betrag = $betrag;

    }

    public function getWaehrung(){

        return $this->waehrung;

    }

    public function setWaehrung($waehrung){

        $this->waehrung = $waehrung;

    }

    public function getIban(){

        return $this->iban;

    }

    public function setIban($iban){

        $this->iban = $iban;

    }

    public function getSwift(){

        return $this->swift;

    }

    public function setSwift($swift){

        $this->swift = $swift;

    }

    public function getBeguenstigter(){

        return $this->beguenstigter;

    }

    public function setBeguenstigter($beguenstigter){

        $this->beguenstigter = $beguenstigter;

    }

    public function getKostenart(){

        return $this->kostenart;

    }

    public function setKostenart($kostenart){

        $this->kostenart = $kostenart;

    }

    public function getFaelligkeit(){

        return $this->faelligkeit;

    }

    public function setFaelligkeit($faelligkeit){

        $this->faelligkeit = $faelligkeit;

    }

    public function getBemerkung(){

        return $this->bemerkung;

    }

    public function setBemerkung($bemerkung){

        $this->bemerkung = $bemerkung;

    }

    public function getReise(){

        return $this->reise;

    }

    public function setReise($reise){

        $this->reise = $reise;

    }

    public function getBezahlt(){

        return $this->bezahlt;

    }

    public function setBezahlt($bezahlt){

        $this->bezahlt = $bezahlt;

    }

    public function getRechnungsID(){

        return $this->rechnungsID;

    }

}