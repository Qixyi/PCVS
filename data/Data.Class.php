<?php

// static class - no need constructor

// wraps around MysqlDataProvider class so no need to create new
// MysqlDataProvider class everytime when it's needed
// - safer,  MysqlDataProvider class values are protected by this class
//require_once("MysqlDataProvider.Class.php");

class Data {

    static private $dataStore;
    static public function initialize(MysqlDataProvider $dataProvider) {
        return self::$dataStore = $dataProvider;
    }

    static public function login($username, $password) {
        return self::$dataStore->login($username, $password);
    }

    static public function getVaccines() {
        return self::$dataStore->getVaccines();
    }


    static public function recordNewBatch($batchNo, $expiryDate, $quantityAvailable, 
    $quantityAdministered, $vaccine) {
        self::$dataStore->recordNewBatch($batchNo, $expiryDate, 
        $quantityAvailable, $quantityAdministered, $vaccine);
    }
}