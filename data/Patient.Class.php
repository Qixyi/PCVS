<?php

require_once("User.Class.php");

class Patient extends User {

    private $ICPassport;

    function getICPassport(){
        return $this->ICPassport;
    }

    function setICPassport($ICPassport){
        $this->ICPassport = $ICPassport;
    }
}