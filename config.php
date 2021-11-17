<?php

require_once("Data/User.Class.php");
require_once("Data/Administrator.Class.php");
require_once("Data/Patient.Class.php");
require_once("Data/Batch.Class.php");
require_once("Data/HealthcareCentre.Class.php");
require_once("Data/MysqlDataProvider.Class.php");
require_once("Data/Vaccination.Class.php");
require_once("Data/Vaccine.Class.php");
require_once("functions.php");

const CONFIG = [
    'db' => 'mysql:dbname=covax;host=localhost;port=3306',
    'db_user' => 'root',
    'db_password' => '' 
];