<?php

class Batch {

    private $batchNo;
    private $expiryDate;
    private $quantityAvailable;
    private $quantityAdministered;
    private $vaccineID;
    private $centreName;

    function getBatchNo(){
        return $this->batchNo;
    }

    function getExpiryDate(){
        return $this->expiryDate;
    }

    function getQuantityAvailable(){
        return $this->quantityAvailable;
    }

    function getQuantityAdministered(){
        return $this->quantityAdministered;
    }

    function getVaccineID(){
        return $this->vaccineID;
    }

    function getCentreName(){
        return $this->centreName;
    }

    function setBatchNo($batchNo){
        $this->batchNo = $batchNo;
    }

    function setExpiryDate($expiryDate){
        $this->expiryDate = $expiryDate;
    }

    function setQuantityAvailable($quantityAvailable){
        $this->quantityAvailable = $quantityAvailable;
    }

    function setQuantityAdministered($quantityAdministered){
        $this->quantityAdministered = $quantityAdministered;
    }

    function setVaccineID($vaccineID){
        $this->vaccineID = $vaccineID;
    }

    function setCentreName($centreName){
        $this->centreName = $centreName;
    }

}