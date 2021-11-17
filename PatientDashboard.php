<?php
session_start();

require_once("config.php");

isUserLoggedIn();
$user = unserialize($_SESSION['user']);
$database = new MysqlDataProvider(CONFIG['db']);
//print_r($user);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient's Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/72b9e1f041.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>
</head>
<body>

      <!-- Top Bar -->
   <div class="navbar sticky-top top-nav-blue">
    <div class="container-fluid">
        <a class="navbar-brand link-light"><img src="covidvax.png" alt="This is the CoVax logo" height="50" width="50">
    <p class="h1 align-middle d-inline-block"> CoVax</p></a>
        <a href="Logout.php"><button type="button" class="btn btn-outline-warning">Log Out</button></a>
    </div>
    </div>  

    <!--Main Content-->
    <div class="container">

        <!-- Page Heading -->
       <h3 class="text-center mb-3 mt-3">Patient's Dashboard</h3>
       <br>

        <div class="text-center mt-5">
            <div class="row justify-content-center mt-5">
                <div class="card bg-primary text-white col-lg-3 mx-2">
                    <div class="card-body text-center">
                        <i class="fas fa-user fa-2x text-white"></i>
                        <h4 class="card-title mt-2 mb-4"> <?php echo $user->getFullName() ?> </h4>
                    </div>
                </div>
            </div>

            <div class="text-center mt-5">
                <?php
                    $apptArray = $database->getVaccinationByUsername($user->getUsername());
                    if(empty($apptArray)) {
                        echo '<a href="RequestVaccinationAppointmentVN.php"><button type="button" 
                        class="btn btn-primary btn-lg">Request Vaccination Appointment</button></a>';
                    }
                ?>
            </div>

    </div>
    
</body>
</html>