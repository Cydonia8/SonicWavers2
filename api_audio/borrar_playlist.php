<?php
require_once "../php_functions/general.php";
    session_start();
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");

    $id = $_GET["id"];
    $con = createConnection();

    $delete = $con->prepare("DELETE FROM playlist_includes where playlist = ?");
    $delete->bind_param('i', $id);
    $delete->execute();
    $delete->close();

    $query_image = $con->prepare("SELECT image from playlists where id = ?");
    $query_image->bind_param('i', $id);
    $query_image->bind_result($image);
    $query_image->execute();
    $query_image->fetch();
    $query_image->close();

    unlink($image);

    $delete_playlist = $con->prepare("DELETE FROM playlists where id = ?");
    $delete_playlist->bind_param('i', $id);
    $delete_playlist->execute();
    $delete_playlist->close();

    $con->close();
