<?php
    session_start();
    header("Access-Control-Allow-Origin: *");
    if(isset($_COOKIE["sesion"])){
        setcookie("sesion","", time()-3600, '/');
        unset($_SESSION['user']);
        unset($_SESSION["user-type"]);
    }else{
        unset($_SESSION['user']);
        unset($_SESSION["user-type"]);
    }