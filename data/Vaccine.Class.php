<?php

class Vaccine {

    private $vaccineID;
    private $manufacturer;
    private $vaccineName;

    function getVaccineID(){
        return $this->vaccineID;
    }

    function getManufacturer(){
        return $this->manufacturer;
    }

    function getVaccineName(){
        return $this->vaccineName;
    }

    function setVaccineID($vaccineID){
        $this->vaccineID = $vaccineID;
    }

    function setManufacturer($manufacturer){
        $this->manufacturer = $manufacturer;
    }

    function setVaccineName($vaccineName){
        $this->vaccineName = $vaccineName;
    }
}