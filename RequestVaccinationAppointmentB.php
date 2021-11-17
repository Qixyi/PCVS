<?php
session_start();

require_once("config.php");

isUserLoggedIn();
$user = unserialize($_SESSION['user']);
$database = new MysqlDataProvider(CONFIG['db']);
//print_r($user);

if(isset($_GET["centreName"]) && isset($_GET["vaccineID"]) ){
  $vaccineID = $_GET["vaccineID"];
  $centreName = str_replace("%20", " " , $_GET["centreName"]);
  unset($_GET["centreName"]);
  unset($_GET["vaccineID"]);
  //echo($centreName);
  //print_r($batchArray);
}else{
  redirect("PatientDashboard.php");
}

if ($_SERVER['REQUEST_METHOD'] === "POST"){
  $batchNo = $_POST["radioBtnB"];
  unset ($_POST["radioBtnB"]);
  $centreName = str_replace(" " , "%20", $_GET["centreName"]);
  redirect("RequestVaccinationAppointmentAD.php?vaccineID=". $vaccineID . "&centreName=" . $centreName . "&batchNo=" . $batchNo);
  
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Request Vaccination Appointment Batches</title>
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
            <li class="breadcrumb-item"><a href="PatientProfile.php">Request Healthcare Centre</a></li>
              <li class="breadcrumb-item active" aria-current="page">Request Batches</li>
            </ol>
          </nav>
        </div>

         <!-- Page Heading -->
       <h3 class="text-center mb-3">3. Select a batch</h3>
       <br>

       <form method = "POST">
       <table class="table table-hover" id="batchesTable" novalidate>
        <thead>
          <tr class="light-cyan-color">
            <th scope="col">Choose</th>
            <th scope="col">Batch No</th>
            <th scope="col">Expiry Date</th>
            <th scope="col">Quantity Available</th>
          </tr>
        </thead>
        <tbody>
        <?php 
          $batchArray = $database->getBatchesByVaccineCentre($vaccineID, $centreName);
          if (!empty($batchArray)):
            foreach($batchArray as $batch):?>
          <tr>
            <td><input type="radio" name="radioBtnB"
            <?php echo " value =" . $batch->getBatchNo() ?>></td> 
            <td><?php echo $batch->getBatchNo(); ?></td>
            <td><?php echo $batch->getExpiryDate(); ?></td>
            <td><?php echo $batch->getQuantityAvailable(); ?></td>
          </tr>
          <?php endforeach; 
            endif;
             ?>
        </tbody>
      </table>
      <div class="invisible text-danger mb-5" id="invalid-vaccine">Please select a Healthcare Centre</div>

      <div class="text-center mb-3">
        <button type="submit" class="btn btn-primary" id="requestBtn">Request</button>
        <button type="cancel" class="btn" id="cancelBtn">Cancel</button>
    </div>

          </form>

</div>
</div>
<script src="RequestVaccinationAppointmentB.js"></script>
</body>
</html>

