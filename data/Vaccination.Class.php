<?php

class Vaccination {

    private $vaccinationID;
    private	$appointmentDate;
    private	$status;
    private $remarks;
    private	$batchNo;
    private	$username;

    function getVaccinationID(){
        return $this->vaccinationID;
    }

    function getAppointmentDate(){
        return $this->appointmentDate;
    }

    function getStatus(){
        return $this->status;
    }

    function getRemarks(){
        return $this->remarks;
    }
    
    function getBatchNo(){
        return $this->batchNo;
    }

    function getUsername(){
        return $this->username;
    }

    function setVaccinationID($vaccinationID){
        $this->vaccinationID = $vaccinationID;
    }

    function setAppointmentDate($appointmentDate){
        $this->appointmentDate = $appointmentDate;
    }

    function setStatus($status){
        $this->status = $status;
    }

    function setRemarks($remarks){
        $this->remarks = $remarks;
    }

    function setBatchNo($batchNo){
        $this->batchNo = $batchNo;
    }

    function setUsername($username){
        $this->username = $username;
    }
}
?>