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
        $this->rechnungsart = $rechnungsdaten['Rechnungsart'];
        $this->betrag = $rechnungsdaten['Betrag'];
        $this->waehrung = $rechnungsdaten['Waehrung'];
        $this->iban = $rechnungsdaten['IBAN'];
        if(array_key_exists('SWIFT', $rechnungsdaten)) $this->swift = $rechnungsdaten['SWIFT'];
        $this->beguenstigter = $rechnungsdaten['Beguenstigter'];
        $this->kostenart = $rechnungsdaten['Kostenart'];
        $this->faelligkeit = $rechnungsdaten['Faelligkeit'];
        if(array_key_exists('Bemerkung', $rechnungsdaten)) $this->bemerkung = $rechnungsdaten['Bemerkung'];
        if(array_key_exists('Reise',$rechnungsdaten)) $this->reise = $rechnungsdaten['Reise'];
        $this->bezahlt = $rechnungsdaten['bezahlt'];
    }

    public static function newRechnung($rechnungsdaten){

        if(array_key_exists('RechnungsID', $rechnungsdaten)) $id = $rechnungsdaten['RechnungsID'];

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

    public function isBezahlt(){

        return $this->bezahlt;

    }

    public function setBezahlt($bezahlt){

        $this->bezahlt = $bezahlt;

    }

    public function getRechnungsID(){

        return $this->rechnungsID;

    }

}