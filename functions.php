<?php
function isUserLoggedIn(){
    if(!(isset($_SESSION['user']))) {
        header("Location: Login.php");
    }
}

function redirectToHome() {
    if(isset($_SESSION['user'])) {
        $user = unserialize($_SESSION['user']);
        if($user instanceof Administrator) {
            redirect("AdminHome.php");
        } else {
            redirect("PatientDashboard.php");
        }
    }
}

function redirect($page) {
    header("Location: $page");
    exit();
}

?>

