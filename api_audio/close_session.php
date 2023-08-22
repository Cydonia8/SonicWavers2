<?php
    session_start();
    header("Access-Control-Allow-Origin: *");
    if(isset($_COOKIE["sesion"])){
        setcookie("sesion","", time()-3600, '/');
        unset($_SESSION["token"]);
    }else{
        unset($_SESSION["token"]);
    }