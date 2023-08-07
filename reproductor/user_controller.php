<?php
    session_start();
    if(!isset($_SESSION["token"])){
        header('location:reproductor_simplificado.php');
    }else{
        header('location:reproductor.php');
    }
?>