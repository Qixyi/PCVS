<?php

abstract class User {

    protected $username;
    protected $password;
    protected $email;
    protected $fullName;

    function getUsername(){
        return $this->username;
    }

    function getPassword(){
        return $this->password;
    }

    function getEmail(){
        return $this->email;
    }

    function getFullName(){
        return $this->fullName;
    }

    function setUsername($username){
        $this->username = $username;
    }

    function setPassword($password){
        $this->password = $password;
    }

    function setEmail($email){
        $this->email = $email;
    }

    function setFullName($fullName){
        $this->fullName = $fullName;
    }
}
