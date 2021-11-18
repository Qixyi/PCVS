<?php
session_start();

require_once("config.php");

isUserLoggedIn();

$user = unserialize($_SESSION['user']);
$database = new MysqlDataProvider(CONFIG['db']);

if(isset($_GET['vaccinationID'])) {
  $vaccinationObj = $database->getVaccinationById($_GET['vaccinationID']);

  if(!empty($vaccinationObj)) {
    $batchObj = $database->getBatchByNo($vaccinationObj->getBatchNo());

    $vaccineObj = $database->getVaccineById($batchObj->getVaccineID());

    $patientObj = $database->getPatientByUsername($vaccinationObj->getUsername());
  } else {
    redirect("AdminHome.php");
  }
} else {
  redirect("AdminHome.php");
}

if($_SERVER['REQUEST_METHOD'] === 'POST') {
  $remarks = trim($_POST['administeredRemarks']);
 $database->updateVaccinationStatus($vaccinationObj->getVaccinationID(), $_POST['acceptRejectRadio'], $remarks);

  // Redirect back to previous page
  if(isset($_SESSION['url'])) {
    redirect($_SESSION['url']);
  } else {
    redirect("AdminAppointment.php");
  }

}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="styles.css" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script
      src="https://kit.fontawesome.com/81cfea1327.js"
      crossorigin="anonymous"
    ></script>
    <title>Confirm Vaccination Appointment</title>
  </head>

  <body>
    <!-- Top Bar -->
    <div class="navbar sticky-top top-nav-blue">
      <div class="container-fluid">
        <a class="navbar-brand link-light" href="AdminHome.php"
          ><img
            src="covidvax.png"
            alt="This is the PCVS logo"
            height="50"
            width="50"
          />
          <p class="h1 align-middle d-inline-block">PCVS</p>
        </a>
        <a href="Logout.php"
          ><button type="button" class="btn btn-outline-warning">
            Log Out
          </button></a
        >
      </div>
    </div>

    <!-- Main Content -->
    <div class="container">
      <!-- Breadcrumbs -->
      <div class="mt-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="AdminHome.php">Home</a></li>
            <li class="breadcrumb-item">
              <?php
                if(isset($_SESSION['url'])) {
                  echo "<a href=". $_SESSION['url'] . ">All Appointments</a>";
                } else {
                  echo "<a href='AdminAppointment.php'>All Appointments</a>";
                }
              ?>
              
            </li>
            <li class="breadcrumb-item active" aria-current="page">
			Confirm Vaccination Appointment
            </li>
          </ol>
        </nav>
      </div>

      <!-- Page Heading -->
      <h3 class="text-center mb-3">Confirm Vaccination Appointment</h3>
      <br/>

      <!-- Batch Details -->
      <div class="container">
        <div class="row offset-4">
          <h5 class="mt-4">Patient Details</h5>
          <div class="col-sm-3">
            <h6>Full name:</h6>
          </div>
          <div class="col-md-3">
            <h6 id="fullName"><?php echo $patientObj->getFullName(); ?></h6>
          </div>
          <div class="w-100"></div>
          <div class="col-md-3">
            <h6>IC/Passport:</h6>
          </div>
          <div class="col-md-3">
            <h6 id="icPassport"><?php echo $patientObj->getICPassport(); ?></h6>
          </div>
          <div class="w-100"></div>

          <h5 class="mt-4">Batch Details</h5>
          <div class="col-md-3">
            <h6>Batch No:</h6>
          </div>
          <div class="col-md-3">
            <h6 id="batchNo"><?php echo $batchObj->getBatchNo();?></h6>
          </div>
          <div class="w-100"></div>
          <div class="col-md-3">
            <h6>Expiry Date:</h6>
          </div>
          <div class="col-md-3">
            <h6 id="expiryDate"><?php echo $batchObj->getExpiryDate(); ?></h6>
          </div>
          <div class="w-100"></div>

          <h5 class="mt-4">Vaccine Details</h5>
          <div class="col-md-3">
            <h6>Vaccine Name:</h6>
          </div>
          <div class="col-md-3">
            <h6 id="vaccineName"><?php echo $vaccineObj->getVaccineName(); ?></h6>
          </div>
          <div class="w-100"></div>
          <div class="col-md-3">
            <h6>Manufacturer:</h6>
          </div>
          <div class="col-md-3">
            <h6 id="manufacturer"><?php echo $vaccineObj->getManufacturer(); ?></h6>
          </div>

          <div class="w-100"></div>
          <form method="POST" class="col-md-5 mt-5 text-center">

		  <fieldset class="row mb-3">
						  <legend class="col-form-label col-sm-4 pt-0">Status : </legend>
						  <div class="col-sm-8">
							<div class="form-check">
								<input class="form-check-input" type="radio" name="acceptRejectRadio" 
								id="acceptRadio" value="confirmed">
								<label class="form-check-label" for="acceptRadio">
								  Accepted
								</label>
							  </div>
							  <div class="form-check">
								<input class="form-check-input" type="radio" name="acceptRejectRadio" 
								id="rejectRadio" value="rejected">
								<label class="form-check-label" for="rejectRadio">
								  Rejected
								</label>
								<div class="invalid-feedback"> Please select a status</div>
							  </div>
						  </div>
						</fieldset>
          
		  <button type="submit" id="confirmVacSaveBtn" class="btn btn-primary ml-3">Save Changes</button>
            
            <button type="button" class="btn btn-secondary ml-3">
            <a class="link-light text-decoration-none "
              href="<?php 
              if(isset($_SESSION['url'])) {
                echo $_SESSION['url'];
              } else {
                echo "AdminAppointment.php";
              } ?>"
              >
              Cancel
              </a>
            </button>
            <input type="hidden" id="confirmedRemarks" name="confirmedRemarks" />
          </form>
        </div>
      </div>
    </div>
    <script type="text/javascript">
      var confirmedBtn = document.getElementById(
        "confirmVacSaveBtn"
      );

      confirmedBtn.addEventListener("click", function (event) {
		  if(checkRadioBtn()){

			var remarks = prompt("Please enter remarks (optional)");
        document.getElementById("confirmedRemarks").value = remarks;

        if (remarks == null || checkRadioBtn() == false) {
          event.preventDefault();
          event.stopPropagation();
        }

		  }else{

			if (remarks == null || checkRadioBtn() == false) {
          event.preventDefault();
          event.stopPropagation();
        }

		  }
    
      });

	function checkRadioBtn(){
		if (!document.getElementById('acceptRadio').checked &&
    !document.getElementById('rejectRadio').checked) {

      addIsInvalid(document.getElementById('acceptRadio'));
      addIsInvalid(document.getElementById('rejectRadio'));
      return false;
    } else {
      addIsValid(document.getElementById('acceptRadio'));
      addIsValid(document.getElementById('rejectRadio'));
      return true;
    }
	  }

	  // Add valid class & removes any invalid class
  function addIsValid(element){
    if(!element.classList.contains("is-valid")){
      element.classList.add("is-valid");
    }
  
    if(element.classList.contains("is-invalid")){
      element.classList.remove("is-invalid");
    }
  }
  
  // Add invalid class & removes any valid class
  function addIsInvalid(element){
    if(!element.classList.contains("is-invalid")){
      element.classList.add("is-invalid");
    }
  
    if(element.classList.contains("is-valid")){
      element.classList.remove("is-valid");
    }
  }

    </script>
  </body>
</html>
