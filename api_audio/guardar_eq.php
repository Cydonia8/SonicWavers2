<?php
    session_start();
    header("Access-Control-Allow-Origin:*");
    $con = new mysqli('localhost', 'root', '', 'sonicwaves');

    if(isset($_GET["lows"]) and isset($_GET["midlows"]) and isset($_GET["mids"]) and isset($_GET["midhighs"]) and isset($_GET["highs"])){
        $lows = $_GET["lows"];
        $midlows = $_GET["midlows"];
        $mids = $_GET["mids"];
        $midhighs = $_GET["midhighs"];
        $highs = $_GET["highs"];

        $update = $con->prepare("UPDATE usuario set low_eq = ?, midlows_eq = ?, mids_eq = ?, midhighs_eq = ?, high_eq = ? where usuario = ?");
        $update->bind_param('ddddds', $lows, $midlows, $mids, $midhighs, $highs, $_SESSION["user"]);
        $update->execute();
        $update->close();
    }
    $con->close();
?>