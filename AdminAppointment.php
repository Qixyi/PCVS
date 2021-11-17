<?php
session_start();

require_once("config.php");

isUserLoggedIn();

$user = unserialize($_SESSION['user']);
$database = new MysqlDataProvider(CONFIG['db']);

// Check if user selected any batch no
if(!isset($_GET['batchNo'])) {
	redirect("AdminHome.php");
}

// Get batch from database
$batchObj = $database->getBatchByNo($_GET['batchNo']);

// Check if batch object is empty 
// OR batch's centreName does not match admin's centreName
if(empty($batchObj) || strcasecmp($batchObj->getCentreName(), $user->getCentreName()) != 0) {
	redirect("AdminHome.php");
} 

$vaccinationArray = $database->getVaccinations($batchObj->getBatchNo());
unset($noVaccination);
if(empty($vaccinationArray)) {
	$noVaccination = true;
}

unset($_SESSION['url']);
// Set URL for Administer.php to come back to this page
$_SESSION['url'] = "AdminAppointment.php?batchNo=" . $_GET['batchNo'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="styles.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
	<script src="https://kit.fontawesome.com/81cfea1327.js" crossorigin="anonymous"></script>
    <title>All Appointments</title>
</head>
<body>
    <!-- Top Bar -->
    <div class="navbar sticky-top top-nav-blue">
        <div class="container-fluid">
            <a class="navbar-brand link-light" href="AdminHome.php"><img src="covidvax.png" alt="This is the CoVax logo" height="50" width="50">
				<p class="h1 align-middle d-inline-block"> PCVS</p></a>
            <a href="Logout.php"><button type="button" class="btn btn-outline-warning">Log Out</button></a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container">
        <!-- Breadcrumbs -->
      <div class="mt-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="AdminHome.php">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">All Appointments</li>
          </ol>
        </nav>
      </div>
      
      <!-- Page Heading -->
      <h3 class="text-center mb-3">All Vaccination Appointments</h3>
      <br>

		<!-- Batch Details -->
		<div class="text-center">
			<h3 class="d-md-inline"><?php echo $user->getCentreName(); ?></h3>
			<br><br>
			<h3 class="d-md-inline">Batch No: </h3>
			<h3 class="d-md-inline"><?php echo $batchObj->getBatchNo(); ?></h3>
			<br>
			<h3 class="d-md-inline">Expiry Date: </h3>
			<h3 class="d-md-inline"><?php echo $batchObj->getExpiryDate();?></h3>
		</div>
		

		<!-- Appointments Summary -->
		<div class="row justify-content-center my-5">
			<div class="card col-lg-3 mx-2">
				<div class="card-body text-center">
					<i class="far fa-check-circle fa-2x text-success"></i>
					<h4 class="card-title mt-2 mb-4">Available</h4>
					<h2 class="card-text"><?php echo $batchObj->getQuantityAvailable();?></h2>
				</div>
			</div>

			
			<div class="card col-lg-3 mx-2">
				<div class="card-body text-center">
					<i class="fas fa-ellipsis-h fa-2x text-warning"></i>
					<h4 class="card-title mt-2 mb-4">Pending</h4>
					<h2 class="card-text">
						<?php
							if(isset($noVaccination)) {
								echo "0";
							} else {
								$numPending = 0;
								foreach ($vaccinationArray as $vax) {
									if(strcasecmp($vax->getStatus(), "pending") == 0){
										$numPending++;
									}
								}
								echo $numPending;
							}
						?>
					</h2>
				</div>
			</div>
			<div class="card col-lg-3 mx-2">
				<div class="card-body text-center">
					<i class="fas fa-syringe fa-2x text-info"></i>
					<h4 class="card-title mt-2 mb-4">Administered</h4>
					<h2 class="card-text"><?php echo $batchObj->getQuantityAdministered();?></h2>
				</div>
			</div>
		</div>

		<!-- Vaccinations Table -->

		<table class="table mb-5" id="appointmentsTable">
			<thead>
				<tr class="light-cyan-color">
					<th scope="col">Vaccination ID</th>
					<th scope="col">Appointment Date</th>
					<th scope="col">Status</th>
					<th scope="col">Action</th>
				</tr>
			</thead>
			<tbody>
				<?php 
					if(!isset($noVaccination)){
						foreach($vaccinationArray as $vax):
							echo "<tr>";
								echo "<th scope='row'>" . $vax->getVaccinationID() ."</th>";
								echo "<td>" . $vax->getAppointmentDate() . "</td>";
								echo "<td>" . $vax->getStatus() . "</td>";

								if(strcasecmp($vax->getStatus(), "pending") == 0) {
									echo "<td><button class='btn btn-primary btn-sm'
								 	 value='" . $vax->getVaccinationID() .
									"' name='statusPending'>Update</button></td>";
								} else if(strcasecmp($vax->getStatus(), "confirmed") == 0) {
									echo "<td><button class='btn btn-primary btn-sm'
								 	 value='" . $vax->getVaccinationID() .
									"' name='statusConfirmed'>Update</button></td>";
								} else {
									echo "<td></td>";
								}
							echo "</tr>";
						endforeach;
					}
				?>
			</tbody>
		</table>

		<?php
            if(isset($noVaccination)): 
				echo "<h4 class='text-center text-secondary'> No vaccinations found </h4>";
            endif;
          ?>
    </div> 
	<script src="AdminAppointment.js"></script>
</body>
</html>