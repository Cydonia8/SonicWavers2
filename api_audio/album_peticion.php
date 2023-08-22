<?php
    require_once "../php_functions/login_register_functions.php";
    require_once "../php_functions/general.php";
    session_start();
    header('Content-Type: application/json');
	header("Access-Control-Allow-Origin: *");

    $con = createConnection();

    if(isset($_SESSION["token"])){
        $decoded = decodeToken($_SESSION["token"]);
        $decoded = json_decode(json_encode($decoded), true);
        $user = $decoded["data"]["user"];
    }
    

    $id = $_GET["id"];
    $query = $con->query("select title, a.picture picture, g.name author, release_date, g.avatar avatar, g.id artist_id from album a, artist g where a.artist = g.id and a.id = $id");
    $album_data = [];
    
    while($row = $query->fetch_array(MYSQLI_ASSOC)){
        $album_data[] = $row;
    }
    $data['album_data'] = $album_data;

    if(isset($_SESSION["token"])){
        $user_query = $con->prepare("SELECT id from user where username = ?");
        $user_query->bind_param('s', $user);
        $user_query->bind_result($id_user);
        $user_query->execute();
        $user_query->fetch();
        $user_query->close();

        $favorite_query = $con->prepare("select count(*) from favorite where album = ? and user = ?");
        $favorite_query->bind_param('ii', $id, $id_user);
        $favorite_query->bind_result($favorite);
        $favorite_query->execute();
        $favorite_query->fetch();
        $favorite_query->close();

        $data["favorite"] = $favorite;
    }

    $num_songs_query = $con->prepare("SELECT count(*) from album_contains where album = ?");
    $num_songs_query->bind_param('i', $id);
    $num_songs_query->bind_result($total_songs);
    $num_songs_query->execute();
    $num_songs_query->fetch();
    $num_songs_query->close();

    $data["total_songs"] = $total_songs;

    $songs_query = $con->query("select i.album album, title, length, file, e.name style, c.id id from songs c, album_contains i, styles e where c.id = i.song and e.id = c.style and i.album = $id");
    $songs_data = [];
    while($row = $songs_query->fetch_array(MYSQLI_ASSOC)){
        $songs_data[] = $row;
    }
    $data["songs_list"] = $songs_data;

    echo json_encode($data);
    $con->close();