<?php
session_start();

require_once("config.php");

isUserLoggedIn();
$user = unserialize($_SESSION['user']);
$database = new MysqlDataProvider(CONFIG['db']);
//print_r($user);

if(isset($_GET["centreName"]) && isset($_GET["vaccineID"])  && isset($_GET["batchNo"]) ){
  $vaccineID = $_GET["vaccineID"];
  $centreName = str_replace("%20", " " , $_GET["centreName"]);
  $batchNo = $_GET["batchNo"];
  unset($_GET["centreName"]);
  unset($_GET["vaccineID"]);
  unset($_GET["batchNo"]);
  //echo($centreName);
  //print_r($batchArray);
}else{
  redirect("PatientDashboard.php");
}

if ($_SERVER['REQUEST_METHOD'] === "POST"){
  $appointmentDate = $_POST["appointmentDate"];
  unset ($_POST["appointmentDate"]);
  $database->getVaccination("", $appointmentDate, "", "pending" , $batchNo, $user->getUsername());
  redirect("PatientDashboard.php");
  
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Appointment Date</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>
</head>
</head>
<body>

  <!-- Top Bar -->
  <div class="navbar sticky-top top-nav-blue">
    <div class="container-fluid">
        <a class="navbar-brand link-light" href="PatientDashboard.php"><img src="covidvax.png" alt="This is the CoVax logo" height="50" width="50">
    <p class="h1 align-middle d-inline-block"> CoVax</p></a>
        <a href="Logout.php"><button type="button" class="btn btn-outline-warning">Log Out</button></a>
    </div>
    </div>  

    <!--Main Content-->
    <div class="container"> 

  <!-- Breadcrumbs -->
  <div class="mt-3">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="PatientDashboard.php">Request Healthcare Centre</a></li>
              <li class="breadcrumb-item active" aria-current="page">Request Date</li>
            </ol>
          </nav>
        </div>

         <!-- Page Heading -->
       <h3 class="text-center mb-3">4. Select a appointment date</h3>
       <br>
<form method = "POST">
      <div class= "row mb-3">
         <label for="appointmentDate" class="pt-2 col-md-3">Appointment Date: </label>
        <div class="col-md-9">
            <input type="date" class="form-control" id="appointmentDate" name="appointmentDate"  placeholder="Appointment Date" required>
              <div class="invalid-feedback">
                Please enter your appointment date (the earliest date is tomorrow).
              </div>
        </div>
      </div>

      <div class="text-center mb-3">
        <button type="submit" class="btn btn-primary" id="requestBtn">Request</button>
        <button type="cancel" class="btn" id="cancelBtn">Cancel</button>
    </div>
</form>
</div>
</div>

<script src="RequestVaccinationAppointmentAD.js"></script>
</body>
</html>

