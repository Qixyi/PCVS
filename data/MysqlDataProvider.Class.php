<?php

require_once("config.php");

class MysqlDataProvider {
    function __construct($source) {
        $this->source = $source;
    }

    function getVaccinationByUsername($username){
        return $this->queryAnObject($username, "Vaccination");
    }

    function insertVaccination($vaccinationID, $appointmentDate, $remarks, $status, $batchNo, $username){
        return $this->execute('INSERT INTO Vaccination (vaccinationID, 
        appointmentDate, remarks, status, batchNo, username)
        VALUES (:vaccinationID, :appointmentDate, :remarks, 
        :status, :batchNo, :username)',
        [
            ':vaccinationID' => $vaccinationID,
            ':appointmentDate' => $appointmentDate,
            ':remarks' => $remarks,
            ':status' => $status,
            ':batchNo' => $batchNo,
            ':username' => $username
        ]);
    }

    function signUpPatient($username, $password, $fullName, $email, $ICPassport) {
        return $this->execute('INSERT INTO Patient (username, password, 
        fullName, email, ICPassport) VALUES (:username, :password, :fullName, 
        :email, :ICPassport)',
        [
            ':username' => $username,
            ':password' => $password,
            ':fullName' => $fullName,
            ':email' => $email,
            ':ICPassport' => $ICPassport
        ]);
    }


    function signUpAdmin($username, $password, $fullName, $email, $staffID, $centreName) {
        return $this->execute('INSERT INTO Administrator (username, 
        password, fullName, email, staffID, centreName)
        VALUES (:username, :password, :fullName, 
        :email, :staffID, :centreName)',
        [
            ':username' => $username,
            ':password' => $password,
            ':fullName' => $fullName,
            ':email' => $email,
            ':staffID' => $staffID,
            ':centreName' => $centreName
        ]);
    }


    
    function getCentreByName($centreName) {
        return $this->queryAnObject($centreName, "HealthcareCentre");
    }

    function getBatchesByVaccineCentre($vaccineID, $centreName){

        $db = $this->connect();

        if($db == null) {
            return [];
        }

        $sql = ('SELECT * FROM Batch WHERE vaccineID = :vaccineID AND centreName = :centreName');

        $query = $db->prepare($sql);

        $query->execute([
            ':vaccineID' => $vaccineID,
            ':centreName' => $centreName
        ]);

        $data = $query->fetchAll(PDO::FETCH_CLASS, 'Batch');

        $query = null;
        $db = null;

        return $data;

    }


    function insertCentre($centreName, $address) {
        $db = $this->connect();

        if($db == null) {
            return;
        }

        $sql = 'INSERT INTO HealthcareCentre (centreName, address)
                VALUES (:centreName, :address)';

        $smt = $db->prepare($sql);

        $smt->execute([
            ':centreName' => $centreName,
            ':address' => $address
        ]);

        $smt = null;
        $db = null;
    }

    function getBatchesByVaccineID($vaccineID){
        return $this->queryObjectsById($vaccineID, "Batch");
    }


    function getCentres(){
        return $this->query("HealthcareCentre");
    }


    // Returns an Administator or Patient object based on the username and password
    // USED in Login.php
    function login($username, $password) {
        $db = $this->connect();

        if($db == null) {
            return;
        }

        $sql = ('SELECT * FROM Administrator WHERE username = :username AND password = :password');
        $smt = $db->prepare($sql);

        $smt->execute([
            ':username' => $username,
            ':password' => $password
        ]);

        $data = $smt->fetchObject('Administrator');
        if($data == false) {
            $sql = ('SELECT * FROM Patient WHERE username = :username AND password = :password');
            $smt = $db->prepare($sql);

            $smt->execute([
                ':username' => $username,
                ':password' => $password
            ]);

            $data = $smt->fetchObject('Patient');
        }

        $smt = null;
        $db = null;

        if(empty($data)){
            return;
        }

        return $data;
    }

    // Returns all vaccine objects
    // USED in AdminAddBatch.php
    function getVaccines() {
        return $this->query("Vaccine");
    }


    // Returns a Vaccine object with a specific ID.
    // USED in AdminHome.php, AdministerAppt.php
    function getVaccineById($vaccineID) {
        return $this->queryAnObject($vaccineID, "Vaccine");
    }


    // Inserts new batch into db
    // USED in AdminAddBatch.php
    function recordNewBatch($batchNo, $expiryDate, $quantityAvailable, 
    $quantityAdministered, $vaccineID, $centreName) {
        return $this->execute('INSERT INTO Batch (batchNo, expiryDate,
        quantityAvailable, quantityAdministered, vaccineID, centreName)
        VALUES (:batchNo, :expiryDate, :quantityAvailable, 
        :quantityAdministered, :vaccineID, :centreName)', 
        [
            ':batchNo' => $batchNo,
            ':expiryDate' => $expiryDate,
            ':quantityAvailable' => $quantityAvailable,
            ':quantityAdministered' => $quantityAdministered,
            ':vaccineID' => $vaccineID,
            ':centreName' => $centreName
        ]);
    }

    // Returns a batch object with the specific batchNo
    // USED in AdminAddBatch.php, AdminAppointment.php, AdministerAppt.php, ConfirmVaccinationAppointment.php
    function getBatchByNo($batchNo) {
        return $this->queryAnObject($batchNo, "Batch");
    }


    // Returns an array of batches based on a centreName.
    // USED in AdminHome.php
    function getBatches($centreName) {
        return $this->queryObjectsById($centreName, "Batch");
    }


    // Returns an array of vaccinations based on a batchNo.
    // USED in AdminHome.php, AdminAppointment.php
    function getVaccinations($batchNo) {
        return $this->queryObjectsById($batchNo, "Vaccination");
    }


    // Returns a vaccination object based on vaccinationID.
    // USED in AdministerAppt.php, ConfirmVaccinationAppointment.php
    function getVaccinationById($vaccinationID) {
        return $this->queryAnObject($vaccinationID, "Vaccination");
    }


    // Returns a patient object based on username.
    // USED in AdministerAppt.php, ConfirmVaccinationAppointment.php
    function getPatientByUsername($username) {
        return $this->queryAnObject($username, "Patient");
    }


    // Update the status and remarks of a vaccination based on the vaccinationID
    // USED in AdministerAppt.php, ConfirmVaccinationAppointment.php
    function updateVaccinationStatus($vaccinationID, $status, $remarks) {
        return $this->execute('UPDATE Vaccination SET status = :status,
        remarks = :remarks WHERE vaccinationID = :vaccinationID', 
        [
            ':vaccinationID' => $vaccinationID,
            ':status' => $status,
            ':remarks' => $remarks
        ]);
    }


    // Update the quantity available and quantity administered based on the batchNo
    // USED in AdministerAppt.php
    function updateBatchQuantity($batchNo, $quantityAvailable, $quantityAdministered) {
        return $this->execute('UPDATE Batch SET quantityAvailable = :quantityAvailable,
        quantityAdministered = :quantityAdministered WHERE batchNo = :batchNo',
        [
            ':batchNo' => $batchNo,
            ':quantityAvailable' => $quantityAvailable,
            ':quantityAdministered' => $quantityAdministered
        ]);
    }


    // Returns a list of objects based on tablename provided
    private function query($tableName) {
        $db = $this->connect();

        if($db == null) {
            return [];
        }

        $query = $db->query("SELECT * FROM $tableName");

        $data = $query->fetchAll(PDO::FETCH_CLASS, $tableName);
        
        $query = null;
        $db = null;

        return $data;
    }

    // Returns an object (if exists) with a particular ID and tablename, else returns false
    private function queryAnObject($id, $tableName) {
        $db = $this->connect();

        if($db == null) {
            return;
        }

        $sql = ("SELECT * FROM $tableName WHERE $id = :$id");
        
        $smt = $db->prepare($sql);

        $smt->execute([
            ":$id" => $id
        ]);

        $data = $smt->fetchObject($tableName);

        $smt = null;
        $db = null;

        return $data;
    }

    // Returns a list of objects with a specific ID and tablename
    private function queryObjectsById($id, $tableName) {
        $db = $this->connect();

        if($db == null) {
            return [];
        }

        $sql = ("SELECT * FROM $tableName WHERE $id = :$id");

        $query = $db->prepare($sql);

        $query->execute([
            ":$id" => $id
        ]);

        $data = $query->fetchAll(PDO::FETCH_CLASS, $tableName);

        $query = null;
        $db = null;

        return $data;
    }

    // Executes the query based on the SQL statement and parameters provided
    private function execute($sql, $params) {
        $db = $this->connect();

        if($db == null) {
            return;
        }

        $smt = $db->prepare($sql);

        $smt->execute($params);

        $smt = null;
        $db = null;
    }


    // Establish the database connection with PhpMyAdmin
    private function connect() {
        try {
            return new PDO($this->source, CONFIG['db_user'], CONFIG['db_password']);
        } catch (PDOException $e) {
            return null;
        }
    }
}