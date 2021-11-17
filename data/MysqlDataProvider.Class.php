<?php

require_once("config.php");

class MysqlDataProvider {
    function __construct($source) {
        $this->source = $source;
    }

    function getVaccinationByUsername($username){

        $db = $this->connect();

        if($db == null) {
            return[];
        }

        $sql = ('SELECT * FROM Vaccination WHERE username = :username');
        $query = $db->prepare($sql);

        $query->execute([
            ':username' => $username
        ]);

        $data = $query->fetchAll(PDO::FETCH_CLASS, 'Vaccination');
        $query = null;
        $db = null;

        return $data;
    }

    function getVaccination($vaccinationID, $appointmentDate, $remarks, $status, $batchNo, $username){

        $db = $this->connect();

        if($db == null) {
            return;
        }

        $sql = 'INSERT INTO Vaccination (vaccinationID, appointmentDate, remarks, status, batchNo, username)
                VALUES (:vaccinationID, :appointmentDate, :remarks, 
                :status, :batchNo, :username)';

        $smt = $db->prepare($sql);

        $smt->execute([
            ':vaccinationID' => $vaccinationID,
            ':appointmentDate' => $appointmentDate,
            ':remarks' => $remarks,
            ':status' => $status,
            ':batchNo' => $batchNo,
            ':username' => $username
        ]);

        $smt = null;
        $db = null;

    }

    function signUpPatient($username, $password, $fullName, $email, $ICPassport) {
        $db = $this->connect();

        if($db == null) {
            return;
        }

        $sql = 'INSERT INTO Patient (username, password, fullName, email, ICPassport)
                VALUES (:username, :password, :fullName, 
                :email, :ICPassport)';

        $smt = $db->prepare($sql);

        $smt->execute([
            ':username' => $username,
            ':password' => $password,
            ':fullName' => $fullName,
            ':email' => $email,
            ':ICPassport' => $ICPassport
        ]);

        $smt = null;
        $db = null;
    }


    function signUpAdmin($username, $password, $fullName, $email, $staffID, $centreName) {
        $db = $this->connect();

        if($db == null) {
            return;
        }

        $sql = 'INSERT INTO Administrator (username, password, fullName, email, staffID, centreName)
                VALUES (:username, :password, :fullName, 
                :email, :staffID, :centreName)';

        $smt = $db->prepare($sql);

        $smt->execute([
            ':username' => $username,
            ':password' => $password,
            ':fullName' => $fullName,
            ':email' => $email,
            ':staffID' => $staffID,
            ':centreName' => $centreName
        ]);

        $smt = null;
        $db = null;
    }


    function getCentreByName($centreName) {
        $db = $this->connect();

        if($db == null) {
            return;
        }

        $sql = ('SELECT * FROM HealthcareCentre WHERE centreName = :centreName');
        $smt = $db->prepare($sql);

        $smt->execute([
            ':centreName' => $centreName
        ]);

        $data = $smt->fetchObject('HealthcareCentre');
        $smt = null;
        $db = null;

        return $data;
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

        $db = $this->connect();

        if($db == null) {
            return [];
        }

        $sql = ('SELECT * FROM Batch WHERE vaccineID = :vaccineID');

        $query = $db->prepare($sql);

        $query->execute([
            ':vaccineID' => $vaccineID
        ]);

        $data = $query->fetchAll(PDO::FETCH_CLASS, 'Batch');

        $query = null;
        $db = null;

        return $data;
        
    }


    function getCentres(){
        $db = $this->connect();

        if($db == null) {
            return [];
        }

        $query = $db->query('SELECT * FROM HealthcareCentre');

        $data = $query->fetchAll(PDO::FETCH_CLASS, 'HealthcareCentre');
        
        $query = null;
        $db = null;

        return $data;
    }




    // Checks if user is valid. Returns user object if exists, else returns false.
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
        $db = $this->connect();

        if($db == null) {
            return [];
        }

        $query = $db->query('SELECT * FROM Vaccine');

        $data = $query->fetchAll(PDO::FETCH_CLASS, 'Vaccine');
        
        $query = null;
        $db = null;

        return $data;
    }


    // Search for a Vaccine object. Returns a Vaccine object if exists, else returns false
    // USED in AdminHome.php, AdministerAppt.php
    function getVaccineById($vaccineID) {
        $db = $this->connect();

        if($db == null) {
            return;
        }

        $sql = ('SELECT * FROM Vaccine WHERE vaccineID = :vaccineID');
        $smt = $db->prepare($sql);

        $smt->execute([
            ':vaccineID' => $vaccineID
        ]);

        $data = $smt->fetchObject('Vaccine');
        $smt = null;
        $db = null;

        return $data;
    }


    // Inserts new batch into db
    // USED in AdminAddBatch.php
    function recordNewBatch($batchNo, $expiryDate, $quantityAvailable, 
    $quantityAdministered, $vaccineID, $centreName) {
        $db = $this->connect();

        if($db == null) {
            return;
        }

        $sql = 'INSERT INTO Batch (batchNo, expiryDate, quantityAvailable, quantityAdministered, vaccineID, centreName)
                VALUES (:batchNo, :expiryDate, :quantityAvailable, 
                :quantityAdministered, :vaccineID, :centreName)';

        $smt = $db->prepare($sql);

        $smt->execute([
            ':batchNo' => $batchNo,
            ':expiryDate' => $expiryDate,
            ':quantityAvailable' => $quantityAvailable,
            ':quantityAdministered' => $quantityAdministered,
            ':vaccineID' => $vaccineID,
            ':centreName' => $centreName
        ]);

        $smt = null;
        $db = null;
    }

    // Checks if batchNo exists. Returns batch object if exist, else returns false.
    // USED in AdminAddBatch.php, AdminAppointment.php, AdministerAppt.php
    function getBatchByNo($batchNo) {
        $db = $this->connect();

        if($db == null) {
            return;
        }

        $sql = ('SELECT * FROM Batch WHERE batchNo = :batchNo');
        
        $smt = $db->prepare($sql);

        $smt->execute([
            ':batchNo' => $batchNo
        ]);

        $data = $smt->fetchObject('Batch');

        $smt = null;
        $db = null;

        return $data;
    }


    // Get batches based on a centreName. Returns an array of Batch objects.
    // USED in AdminHome.php
    function getBatches($centreName) {
        $db = $this->connect();

        if($db == null) {
            return [];
        }

        $sql = ('SELECT * FROM Batch WHERE centreName = :centreName');

        $query = $db->prepare($sql);

        $query->execute([
            ':centreName' => $centreName
        ]);

        $data = $query->fetchAll(PDO::FETCH_CLASS, 'Batch');

        $query = null;
        $db = null;

        return $data;
    }


    // Get vaccinations based on a batchNo. Returns an array of Vaccination objects.
    // USED in AdminAppointment.php
    function getVaccinations($batchNo) {
        $db = $this->connect();

        if($db == null) {
            return [];
        }

        $sql = ('SELECT * FROM Vaccination WHERE batchNo = :batchNo');

        $query = $db->prepare($sql);

        $query->execute([
            ':batchNo' => $batchNo
        ]);

        $data = $query->fetchAll(PDO::FETCH_CLASS, 'Vaccination');

        $query = null;
        $db = null;

        return $data;
    }

    // Get a vaccination object based on vaccinationID. Returns the object if exists, else returns false
    // USED in AdministerAppt.php
    function getVaccinationById($vaccinationID) {
        $db = $this->connect();

        if($db == null) {
            return;
        }

        $sql = ('SELECT * FROM Vaccination WHERE vaccinationID = :vaccinationID');
        
        $smt = $db->prepare($sql);

        $smt->execute([
            ':vaccinationID' => $vaccinationID
        ]);

        $data = $smt->fetchObject('Vaccination');

        $smt = null;
        $db = null;

        return $data;
    }

    function getPatientByUsername($username) {
        $db = $this->connect();

        if($db == null) {
            return;
        }

        $sql = ('SELECT * FROM Patient WHERE username = :username');
        
        $smt = $db->prepare($sql);

        $smt->execute([
            ':username' => $username
        ]);

        $data = $smt->fetchObject('Patient');

        $smt = null;
        $db = null;

        return $data;
    }

    // Update the status and remarks of a vaccination based on the vaccinationID
    // USED in AdministerAppt.php
    function updateVaccinationStatus($vaccinationID, $status, $remarks) {
        $db = $this->connect();

        if($db == null) {
            return;
        }

        $sql = 'UPDATE Vaccination SET status = :status,
                remarks = :remarks WHERE vaccinationID = :vaccinationID';

        $smt = $db->prepare($sql);

        $smt->execute([
            ':vaccinationID' => $vaccinationID,
            ':status' => $status,
            ':remarks' => $remarks
        ]);

        $smt = null;
        $db = null;
    }

    // Update the quantity available and quantity administered based on the batchNo
    // USED in AdministerAppt.php
    function updateBatchQuantity($batchNo, $quantityAvailable, $quantityAdministered) {
        $db = $this->connect();

        if($db == null) {
            return;
        }

        $sql = 'UPDATE Batch SET quantityAvailable = :quantityAvailable,
                quantityAdministered = :quantityAdministered WHERE batchNo = :batchNo';

        $smt = $db->prepare($sql);

        $smt->execute([
            ':batchNo' => $batchNo,
            ':quantityAvailable' => $quantityAvailable,
            ':quantityAdministered' => $quantityAdministered
        ]);

        $smt = null;
        $db = null;
    }


    private function connect() {
        try {
            return new PDO($this->source, CONFIG['db_user'], CONFIG['db_password']);
        } catch (PDOException $e) {
            return null;
        }
    }
}