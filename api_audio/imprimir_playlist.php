<?php
require_once "../php_functions/general.php";
    session_start();
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");
    $con = createConnection();
    $id = $_GET["id"];

    $query_playlist_data = $con->prepare("SELECT l.title title, image, pl_date, u.username author, avatar from playlists l, user u where u.id = l.user and l.id = ?");
    $query_playlist_data->bind_param('i', $id);
    $query_playlist_data->execute();
    $data_results = $query_playlist_data->get_result();

    $playlist_data = [];

    while($row = $data_results->fetch_assoc()){
        $playlist_data[] = $row;
    }

    $data["playlist_data"] = $playlist_data;
    $query_playlist_data->close();

    $query_playlist_songs = $con->prepare("SELECT distinct a.id album, c.title title, length, c.id id, file, g.name author from artist g, songs c, playlist_includes co, album a, album_contains i where c.id = co.song and a.id = i.album and i.song = co.song and a.active = 1 and g.id = a.artist and co.playlist = ? group by c.id order by order asc");
    $query_playlist_songs->bind_param('i', $id);
    $query_playlist_songs->execute();
    $playlist_songs_results = $query_playlist_songs->get_result();

    $songs_data = [];
    
    while($row = $playlist_songs_results->fetch_assoc()){
        $songs_data[] = $row;
    }

    $data["songs_data"] = $songs_data;

    echo json_encode($data);