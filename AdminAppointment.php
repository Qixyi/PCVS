<?php
session_start();

//echo $_SERVER['DOCUMENT_ROOT'];

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
				<p class="h1 align-middle d-inline-block"> CoVax</p></a>
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

		<!-- Confirm Vaccination Appointment Modal -->
		<div class="modal fade" id="confirmedModal" tabindex="-1" 
		aria-labelledby="confirmedModalLabel" aria-hidden="true">
			<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
				<h5 class="modal-title" id="confirmedModalLabel">
					Confirm Vaccination Appointment</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal"
				 aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<h5>Patient Details</h5>
					<div class="row">
						<div class="col-md-4">
							<h6>Full name: </h6>
						</div>
						<div class="col-md-8">
							<h6 id="confirmedModalFullName">April Young</h6>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<h6>IC/Passport: </h6>
						</div>
						<div class="col-md-8">
							<h6 id="confirmedModalICPassport">010555-14-0550</h6>
						</div>
					</div>
					<h5 class="mt-4">Batch Details</h5>
					<div class="row">
						<div class="col-md-4">
							<h6>Batch No: </h6>
						</div>
						<div class="col-md-8">
							<h6 id="confirmedModalBatchNo">B000001</h6>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<h6>Expiry Date: </h6>
						</div>
						<div class="col-md-8">
							<h6 id="confirmedModalExpiryDate">27/12/2022</h6>
						</div>
					</div>
					<h5 class="mt-4">Vaccine Details</h5>
					<div class="row">
						<div class="col-md-4">
							<h6>Manufacturer: </h6>
						</div>
						<div class="col-md-8">
							<h6 id="confirmedModalManufacturer">Pfizer Inc.</h6>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<h6>Vaccine Name: </h6>
						</div>
						<div class="col-md-8">
							<h6 id="confirmedModalVaccineName">Pfizer</h6>
						</div>
					</div>
					<h4 class="mt-4 light-cyan-color text-center" 
					id="confirmedModalStatus">Status: Pending</h4>
					<hr>
					<form>
						<fieldset class="row mb-3">
						  <legend class="col-form-label col-sm-4 pt-0">Status : </legend>
						  <div class="col-sm-8">
							<div class="form-check">
								<input class="form-check-input" type="radio" name="acceptRejectRadio" 
								id="acceptRadio" data-bs-toggle="collapse" data-bs-target="#confirmedModalRemarksDiv">
								<label class="form-check-label" for="acceptRadio">
								  Accepted
								</label>
							  </div>
							  <div class="form-check">
								<input class="form-check-input" type="radio" name="acceptRejectRadio" 
								id="rejectRadio" data-bs-toggle="collapse" data-bs-target="#confirmedModalRemarksDiv">
								<label class="form-check-label" for="rejectRadio">
								  Rejected
								</label>
							  </div>
						  </div>
						</fieldset>
						
						<div class="row mb-3 collapse" id="confirmedModalRemarksDiv">
							<label for="confirmedModalRemarks" class="col-sm-4 col-form-label">
								Remarks (optional): </label>
							<div class="col-sm-8">
								<textarea class="form-control" id="confirmedModalRemarks" rows="3"></textarea>
							</div>
						</div>
						<div class="text-center">
							<button type="submit" class="btn btn-primary" 
							id="acceptRejectApointmentSaveBtn">Save changes</button>
							<button type="button" class="btn btn-secondary"
							 data-bs-dismiss="modal">Cancel</button>
						</div>	
					  </form>
				</div>
			</div>
			</div>
		</div>


		<!-- Record Vaccination Administered Modal -->
		<div class="modal fade" id="administeredModal" tabindex="-1"
		 aria-labelledby="administeredModalLabel" aria-hidden="true">
			<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
				<h5 class="modal-title" id="administeredModalLabel">
					Record Vaccination Administered</h5>
				<button type="button" class="btn-close" 
				data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<h5>Patient Details</h5>
					<div class="row">
						<div class="col-md-4">
							<h6>Full name: </h6>
						</div>
						<div class="col-md-8">
							<h6 id="administeredModalFullName">May Lee</h6>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<h6>IC/Passport: </h6>
						</div>
						<div class="col-md-8">
							<h6 id="administeredModalICPassport">010555-14-0550</h6>
						</div>
					</div>
					<h5 class="mt-4">Batch Details</h5>
					<div class="row">
						<div class="col-md-4">
							<h6>Batch No: </h6>
						</div>
						<div class="col-md-8">
							<h6 id="administeredModalBatchNo">B000001</h6>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<h6>Expiry Date: </h6>
						</div>
						<div class="col-md-8">
							<h6 id="administeredModalExpiryDate">27/12/2022</h6>
						</div>
					</div>
					<h5 class="mt-4">Vaccine Details</h5>
					<div class="row">
						<div class="col-md-4">
							<h6>Manufacturer: </h6>
						</div>
						<div class="col-md-8">
							<h6 id="administeredModalManufacturer">Pfizer Inc.</h6>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<h6>Vaccine Name: </h6>
						</div>
						<div class="col-md-8">
							<h6 id="administeredModalVaccineName">Pfizer</h6>
						</div>
					</div>
					<h4 class="mt-4 light-cyan-color text-center" 
					id="administeredModalStatus">Status: Confirmed</h4>
					<hr>
					<form>
						<fieldset class="row mb-3">
						  <legend class="col-form-label col-sm-4 pt-0">Status: </legend>
						  <div class="col-sm-8">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" 
								value="administered" id="administeredCheckbox"
								data-bs-toggle="collapse" data-bs-target="#administeredModalRemarksDiv">

								<label class="form-check-label" for="administeredCheckbox">
								  Administered
								</label>
							</div>
						  </div>
						</fieldset>
						<!-- Collapsed Remarks Div -->
						<div class="row mb-3 collapse" id="administeredModalRemarksDiv">
							<label for="administeredModalRemarks" 
							class="col-sm-4 col-form-label">Remarks (optional): </label>
							<div class="col-sm-8">
								<textarea class="form-control" 
								id="administeredModalRemarks" rows="3"></textarea>
							</div>
						</div>
						<div class="text-center">
							<button type="submit" class="btn btn-primary" 
							id="administeredVaccinationSaveBtn">Save changes</button>
							<button type="button" class="btn btn-secondary" 
							data-bs-dismiss="modal">Cancel</button>
						</div>	
					  </form>
				</div>
			</div>
			</div>
		</div>
    </div> 
	<script src="AdminAppointment.js"></script>
</body>
</html>