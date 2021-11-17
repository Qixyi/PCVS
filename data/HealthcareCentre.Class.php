<?php

class HealthcareCentre {

    private $centreName;
    private $address;

    function getCentreName(){
        return $this->centreName;
    }

    function getAddress(){
        return $this->address;
    }

    function setCentreName($centreName){
        $this->centreName = $centreName;
    }

    function setAddress($address){
        $this->address = $address;
    }
}