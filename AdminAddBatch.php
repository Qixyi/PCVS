<?php
session_start();

require_once("config.php");

isUserLoggedIn();

$user = unserialize($_SESSION['user']);
$database = new MysqlDataProvider(CONFIG['db']);
$status = true;

if($_SERVER['REQUEST_METHOD'] === 'POST') {

  $batchNo = trim($_POST['batchNo']);
  $expiryDate = trim($_POST['expiryDate']);
  $qtyAvailable = trim($_POST['qtyAvailable']);
  $qtyAdministered = 0;
  $vaccineID = trim($_POST['vaccineName']);
  $centreName = $user->getCentreName();

  if(empty($database->getBatchByNo($batchNo))){
    $database->recordNewBatch($batchNo, $expiryDate, $qtyAvailable, $qtyAdministered, $vaccineID, $centreName);
    $database = null;
    header("Location: AdminHome.php");
    exit();

  } else {
    $status = false;
  } 
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    <title>Add New Batch</title>
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
            <li class="breadcrumb-item active" aria-current="page">Add Batch</li>
          </ol>
        </nav>
      </div>
      
      <!-- Page Heading -->
      <h3 class="text-center mb-3">Record New Vaccine Batch</h3>
      <br>

      <!-- Form -->
      <form method="POST" class="row needs-validation" novalidate>
        <div class="col-md-8 offset-md-2">
            <div class="row mb-3">
              <label for="vaccineName" class="pt-2 col-lg-3">Vaccine Name: </label>
              <div class="col-lg-9">
                  <select class="form-select" id="vaccineName" name="vaccineName" required>
                      <option selected disabled value="">Choose...</option>
                      <?php $vaccineArray = $database->getVaccines();
                        if (!empty($vaccineArray)):
                          foreach($vaccineArray as $vaccine):?>

                            <option value="<?php echo $vaccine->getVaccineID(); ?>">
                            <?php echo $vaccine->getVaccineName(); ?></option>;

                      <?php
                        endforeach;
                        endif;
                      ?>
                  </select>
                  <div class="invalid-feedback">
                    Please select a vaccine.
                  </div>
              </div>

            </div>

            <!-- <div class="row mb-5">
                <label for="vaccineID" class="col-lg-3 col-form-label">Vaccine ID:</label>
                <div class="col-lg-3">
                    <input type="text" readonly class="form-control-plaintext" id="vaccineID" value="V0001" name="vaccineID">
                </div>
                <label for="manufacturer" class="col-lg-3 col-form-label">Manufacturer:</label>
                <div class="col-lg-3">
                    <input type="text" readonly class="form-control-plaintext" id="manufacturer" value="Company A" name="manufacturer">
                </div>
            </div> -->

            <div class="row mb-3">
                <label for="batchNo" class="pt-2 col-md-3">Batch No: </label>
                <div class="col-md-9">
                    <input type="text" class="form-control" id="batchNo" name="batchNo" placeholder="Batch No" required>
                      <div class="invalid-feedback">
                        Please enter in this format - B followed by 6 numbers (e.g. B000001).
                      </div>
                      <span class="text-danger">
                        <?php
                        if($status === false){
                          echo "Please enter a new Batch No. Existing Batch No is already chosen.";
                          unset($status);
                        }
                        ?>
                      </span>
                </div>

            </div>
            <div class="row mb-3">
                <label for="expiryDate" class="pt-2 col-md-3">Expiry Date: </label>
                <div class="col-md-9">
                    <input type="date" class="form-control" id="expiryDate" name="expiryDate" placeholder="Expiry Date" required>
                      <div class="invalid-feedback">
                        Please enter an expiry date in dd/mm/yyyy format (the earliest date is tomorrow).
                      </div>
                </div>
            </div>
            <div class="row mb-5">
                <label for="qtyAvailable" class="pt-2 col-lg-3">Quantity Available: </label>
                <div class="col-lg-9">
                    <input type="number" class="form-control col-md-5" id="qtyAvailable" name="qtyAvailable"
                        placeholder="Quantity Available" min="1" required>
                        <div class="invalid-feedback">
                        Please enter a number greater than 0.
                        </div>
                </div>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary" id="confirmBtn">Confirm</button>
                <button type="button" class="btn" id="cancelBtn" onclick="location.href='AdminHome.php'">Cancel</button>
            </div>
        </div>
      </form>
    </div>

    <script src="AdminAddBatch.js"></script>
  </body>
</html>