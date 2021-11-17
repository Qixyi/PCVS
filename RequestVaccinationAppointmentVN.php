<?php
session_start();

require_once("config.php");

isUserLoggedIn();
$user = unserialize($_SESSION['user']);
$database = new MysqlDataProvider(CONFIG['db']);
//print_r($user);

if ($_SERVER['REQUEST_METHOD'] === "POST"){
  $vaccineID = $_POST["radioBtnVaccine"];
  unset ($_POST["radioBtnVaccine"]);
  redirect("RequestVaccinationAppointmentHC.php?vaccineID=" . $vaccineID);
  //echo($vaccineID);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vaccine Name</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>
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
              <li class="breadcrumb-item"><a href="PatientDashboard.php">Patient's Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Request Vaccine Name</li>
            </ol>
          </nav>
        </div>

        <!--Full Name-->
       <h3 class="text-center mb-3"></h3>
       <br>

       <h3 class=text-center mb-3><?php $user->getFullName() ?></h3>

       <!-- Page Heading -->
       <h3 class="text-center mb-3">1. Select a vaccine name</h3>
       <br>

       <form method = "POST">
      <table class="table table-hover" id="vaccineTable" novalidate>
        <thead>
          <tr class="light-cyan-color">
            <th scope="col">Choose</th>
            <th scope="col">Vaccine Name</th>
            <th scope="col">Manufacturer</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          $vaccineNameArray = $database->getVaccines();
          if (!empty($vaccineNameArray)):
            foreach($vaccineNameArray as $vaccine):?>
        
          <tr>
            <td><input type="radio" name="radioBtnVaccine"
            <?php echo " value =" . $vaccine->getVaccineID() ?>></td>
            <td> <?php echo $vaccine->getVaccineName(); ?></td>
            <td><?php echo $vaccine->getManufacturer(); ?></td>
          </tr>
            <?php endforeach; 
            endif;
             ?>
        </tbody>
      </table>
      <div class="invisible text-danger mb-5" id="invalid-vaccine">Please select a vaccine</div>

      <div class="text-center mb-3">
        <button type="submit" class="btn btn-primary" id="requestBtn">Request</button>
        <button type="cancel" class="btn" id="cancelBtn">Cancel</button>
    </div>

            </form>

    </div>
    <script src="RequestVaccinationAppointmentVN.js"></script>
</body>
</html>