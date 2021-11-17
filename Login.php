<?php

    session_start();

    require_once("config.php");

    $database = new MysqlDataProvider(CONFIG['db']);

    if(isset($_SESSION['user'])) {
        redirectToHome();
    }

    $status = true;

    // if(isset($_SESSION['user'])) {
    //     $_SESSION['user'] = serialize($loggedInUser);
    //     if($_SESSION['user'] instanceof Administrator) {
    //         header("Location: AdminHome.php");
    //         exit();
    //     } else {
    //         header("Location: PatientProfile.php");
    //         exit();
    //     }
    // }
    
    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        $username = trim($_POST["username"]);
        $password = trim($_POST["password"]);

        $loggedInUser = $database->login($username, $password);

        // print_r($loggedInUser);

        if($loggedInUser != false){
            $_SESSION['user'] = serialize($loggedInUser);
            redirectToHome();

            // if($loggedInUser instanceof Administrator) {
            //     header("Location: AdminHome.php");
            //     exit();
            // } else {
            //     header("Location: PatientProfile.php");
            //     exit();
            // }
                
        } else {
            $status = false;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
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
            <a class="navbar-brand link-light" href="#"><img src="covidvax.png" alt="This is the CoVax logo" height="50" width="50">
        <p class="h1 align-middle d-inline-block"> CoVax</p></a>
            <a href="SignUp.php"><button type="button" class="btn btn-outline-warning">Sign Up</button></a>
        </div>
      </div>

       <!--Login Form-->
       <div class="container mt-5">
        <section class="container-fluid d-flex align-items-center">
            <div class="container">
                <div class="row d-flex align items-center bg-white">
                    <div class="col-md-6 p-0">
                        <img src="covidvaccine.png" alt="Vaccine" class="img-fluid rounded-circle">
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-12 mb-lg-4 mb-3 px-md-5"> 
                                <form method="POST" class="px-md-5 px-2 needs-validation" id="loginForm" novalidate>
                                    <h1 class="text-md-start text-center">Login</h1>
                                    <!--Login Form--> 
                                    <div class="form-floating-mb-3">
                                        <label for="username">Username</label>
                                        <input type="text" class="form-control btn-lg" id="username"
                                        name="username" placeholder="Username" required>
                                        <div class="invalid-feedback">Please enter a username.</div>
                                    </div>
                                    <div class="form-floating-mb-3">
                                        <label for="password">Password</label>
                                        <input type="password" class="form-control btn-lg" id="password"
                                        name="password" placeholder="Password" required>
                                        <div class="invalid-feedback">Please enter your password [7 to 15 characters
                                            which contain only characters, numeric digits, underscore and first
                                            character must be a letter].</div>
                                    </div>
                                    <span class="text-danger">
                                            <?php
                                            if($status == false){
                                                echo "Account not found. Please check your details.";
                                                unset($status);
                                            }
                                            // if(isset($_GET['x'])){
                                            //     echo "Account not found. Please check your details.";
                                            //     unset($_GET['x']);
                                            // }
                                            ?>
                                    </span>
                                    
                                    <!--Login Button-->
                                    <div class="login-btn d-flex justify-content-md-start mt-3 justify-content-center">
                                        <input type="submit" class="btn btn-primary mb-md-0 mb-5 btn-lg " id="loginBtn" value="Login">
                                    </div>                                      
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        </div>
        
    <script src="Login.js"></script>
</body>
</html>