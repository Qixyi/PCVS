<?php

session_start();

require_once("config.php");

$database = new MysqlDataProvider(CONFIG['db']);
if(isset($_SESSION['user'])) {
    redirectToHome();
}

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if(isset( $_POST["signUpBtn"])){

        $patientRadio = $_POST["accTypeRadio"];
   
    //include all common data
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);
    $fullName = trim($_POST["fullName"]);
    $email = trim($_POST["email"]);
    
    // check which radio button is selected
    if(strcasecmp( $patientRadio, "patient")==0) {
        $ICPassport = trim($_POST["ICPassport"]);
        $database->signUpPatient($username, $password, $fullName, $email, $ICPassport);
        $database = null;
        header("Location: Login.php");
        exit(); 

    } else { 

                $staffID = trim($_POST["staffID"]);
                $centreName = trim($_POST["centreName"]);
                $database->signUpAdmin($username, $password, $fullName, $email, $staffID, $centreName);
                $database = null;
                header("Location: Login.php");
                exit();   

    }

    }else{
        $centreName = trim($_POST["centreNameTextInput"]);
        $address = trim($_POST["address"]);
        if(empty($database->getCentreByName($centreName))){
            $database->insertCentre($centreName, $address);
        }else{
            $status = false;
        }
    }
    
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign Up</title>
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
        <a class="navbar-brand link-light" href="RecordVaccine.html"><img src="covidvax.png" alt="This is the CoVax logo" height="50" width="50">
    <p class="h1 align-middle d-inline-block"> CoVax</p></a>
        <a href="Login.php"><button type="button" class="btn btn-outline-warning">Login</button></a>
    </div>
</div>  

<div class="container">
    
<h3 class="text-center mt-3">Welcome to CoVax!</h3>
<form method="POST" class="text-center needs-validation" novalidate>

<?php

if(isset($status)){
    echo '<script language="javascript">';
    echo "alert('Centre Name already exist!')";
    echo '</script>';
    unset ($status);
}

?>

    <!--Radio Button-->
    <label for="username">User Type:</label>
    <div class="form-check mt-3 d-md-inline-block mr-2 ">
        <input class="form-check-input" type="radio" name="accTypeRadio" value="admin"
            onclick="adminClick()" id="flexRadioDefaultAdmin">
        <label class="form-check-label" for="flexRadioDefaultAdmin">
            Healthcare Administrator
        </label>
    </div>
    <div class="form-check d-md-inline-block">
        <input class="form-check-input" type="radio" name="accTypeRadio" value="patient"
            onclick="patientClick()" id="flexRadioDefaultPatient">
        <label class="form-check-label" for="flexRadioDefaultPatient">
            Patient
        </label>
        <div class="invalid-feedback">Please select a User type</div>
    </div>
   
      <!--Centre Name-->
      <div class="form-floating-mb-3 inline-block mr-2 invisible" id="selectCentre" novalidate>
        <label for="selectCentreName" class="form-floating-mb-3">Select Centre</label>
        <div class="form-floating-mb-3">
            <select class="form-floating-center-mb-3 mt-5" name= "centreName" id="selectCentreName">
            <option selected disabled value="">Choose...</option>
            <?php $healthcarecentreArray = $database->getCentres();
                foreach($healthcarecentreArray as $healthcare):?>
                <option value="<?php echo $healthcare->getCentreName(); ?>">
                          <?php echo $healthcare->getCentreName(); ?></option>;
                      <?php endforeach;?>
            </select>
            <div class="invalid-feedback">Please select a Healthcare Centre</div>
        </div>
        <br>

          <!-- (DELETE) TEST MODAL : Button trigger -->
          <button type="button" class="btn btn-primary" data-bs-toggle="modal"
          data-bs-target="#exampleModal">
          Create Healthcare Centre
          </button>
          <br>
                    
       </div>

            <!--Sign Up Form-->
            <div class="box form-floating-mb-3 mt-5">
                <h3 class="text-center mt-3">Sign Up</h3>
                <label for="fullName">Full Name</label>
                <input type="text" class="form-control" id="fullName" name="fullName"
                    placeholder="Full Name" required>
                <div class="invalid-feedback">Please enter your full name</div>
            </div>
            <div class="form-floating-mb-3">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username"
                    placeholder="Username" required>
                <div class="invalid-feedback">Please enter a username</div>
            </div>
            <div class="form-floating-mb-3">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password"
                    placeholder="Password" required>
                <div class="invalid-feedback">Please enter your password [8 to 15 characters
                    which contain only characters, numeric digits, underscore and first
                    character must be a letter]</div>
            </div>
            <div class="form-floating-mb-3">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Email"
                    required>
                <div class="invalid-feedback">Please enter your email in this format
                    coVax@gmail.com </div>
            </div>
            <div class="form-floating-mb-3 invisible" id="staffIDDiv">
                <label for="staffID">Staff ID</label>
                <input type="text" class="form-control" id="staffID" name="staffID"
                    placeholder="Staff ID" required>
                <div class="invalid-feedback">Please enter your in this format HA0001</div>
            </div>
            <div class="form-floating-mb-3 invisible" id="ICPassportDiv">
                <label for="icPassport">IC/Passport</label>
                <input type="text" class="form-control " id="icPassport" name="icPassport"
                    placeholder="IC/Passport" required>
                <div class="invalid-feedback">Please enter your IC or Passport no</div>
            </div>

              <!--Sign Up Button-->
              <div class="signup-btn text-center mt-3">
                <input type="submit" class="btn btn-primary mb-md-0 mb-5 btn-lg " id="signUpBtn"
                    value="Sign Up" name="signUpBtn">
            </div>                 
        </form>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Healthcare
                            Centre</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" class="needs-validation" novalidate> 
                            <div class="row">
                                <div class=" col-md-8">
                                    <label for="centreNameTextInput" class="col-md-8">Centre
                                        Name:
                                    </label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" class="col-md-8" id="centreNameTextInput" name="centreNameTextInput"
                                        placeholder="Centre Name" required>
                                    <div class="invalid-feedback">Please enter a centre name.</div>
                                </div>
                                <div class="col-md-8 mt-2">
                                    <label for="address" class="col-md-8">Address:
                                    </label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" class="col-md-8" id="address" name="address"
                                        placeholder="Address" required>
                                    <div class="invalid-feedback">Please enter an address.</div>
                                </div>
                                <div class="text-center mt-5">
                                    <button type="submit" class="btn btn-primary"
                                        id="createBtn" name= "createBtn">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</div>
<script src="SignUp.js"></script>
</body>
</html>