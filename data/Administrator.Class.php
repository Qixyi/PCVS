<?php

require_once("User.Class.php");

class Administrator extends User {

    private $staffID;
    private $centreName;

    function getStaffID(){
        return $this->staffID;
    }

    function getCentreName(){
        return $this->centreName;
    }

    function setStaffID($staffID){
        $this->staffID = $staffID;
    }

    function setCentreName($centreName){
        $this->centreName = $centreName;
    }
}