<?php
    require_once "../php_functions/general.php";
    session_start();
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");
    $con = createConnection();
    $pattern = $_GET["patron"];
    $formated_pattern = '%'.$pattern.'%';
    $artist_query = $con->prepare("SELECT id, name, avatar from artist where active = 1 and name like ?");
    $artist_query->bind_param('s', $formated_pattern);
    $artist_query->execute();
    $artist_results = $artist_query->get_result();
    $artist_matches = [];

    while($row = $artist_results->fetch_assoc()){
        $artist_matches[] = $row;
    }
    $data["artists"] = $artist_matches;
    $artist_query->close();

    $albums_query = $con->prepare("SELECT a.id id, a.picture picture, title, g.name artist from album a, artist g where a.artist = g.id and a.active = 1 and a.title like ?");
    $albums_query->bind_param('s', $formated_pattern);
    $albums_query->execute();
    $albums_results = $albums_query->get_result();
    $albums_matches = [];

    while($row = $albums_results->fetch_assoc()){
        $albums_matches[] = $row;
    }
    $data["albums"] = $albums_matches;
    $albums_query->close();

    $songs_query = $con->prepare("SELECT c.id id, file, c.title title, a.picture picture, g.name author from songs c, album a, album_contains i, artist g where c.id = i.song and a.id = i.album and g.id = a.artist and a.active = 1 and c.title like ?");
    $songs_query->bind_param('s', $formated_pattern);
    $songs_query->execute();
    $songs_results = $songs_query->get_result();
    $songs_matches = [];

    while($row = $songs_results->fetch_assoc()){
        $songs_matches[] = $row;
    }
    $data["songs"] = $songs_matches;
    $songs_query->close();
    $con->close();

    echo json_encode($data);
