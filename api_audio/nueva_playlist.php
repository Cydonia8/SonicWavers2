<?php
    require_once "../php_functions/login_register_functions.php";
    require_once "../php_functions/general.php";
    session_start();
    
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");

    $decoded = decodeToken($_SESSION["token"]);
    $decoded = json_decode(json_encode($decoded), true);
    $user = $decoded["data"]["user"];

    $date = date('Y-m-d');
    $con = createConnection();
    $id_user = $con->prepare("SELECT id from user where username = ?");
    $id_user->bind_param('s', $user);
    $id_user->bind_result($id);
    $id_user->execute();
    $id_user->fetch();
    $id_user->close();
    $new_id = getAutoID("lista");

    $query_list_number = $con->prepare("SELECT count(*) total from playlists l, user u where u.id = l.user and u.username = ?");
    $query_list_number->bind_param('s', $user);
    $query_list_number->bind_result($num_playlist);
    $query_list_number->execute();
    $query_list_number->fetch();
    $query_list_number->close();

    $num_playlist = ++$num_playlist;

        $name = $_POST["nombre"] != "" ? $_POST["nombre"] : "Lista".$num_playlist;
        if(isset($_FILES["foto"]["type"])){
            $foto_type = $_FILES["foto"]["type"];
            $new_name;
            switch($foto_type){
                case "image/jpeg":
                    $new_name = $user.'lista'.$num_playlist.'.jpeg';
                    break;
                case "image/webp":
                    $new_name = $user.'lista'.$num_playlist.'.webp';
                    break;
                case "image/png":
                    $new_name = $user.'lista'.$num_playlist.'.png';
                    break;
            }
            if(!file_exists('../media/img_users/'.$user)){
                mkdir('../media/img_users/'.$user);
            }
            $new_path = '../media/img_users/'.$user.'/'.$new_name;
            move_uploaded_file($_FILES["foto"]["tmp_name"], $new_path);
        }else{
            $default_path = '../media/assets/no_cover.jpg';
            if(!file_exists('../media/img_users/'.$user)){
                mkdir('../media/img_users/'.$user);
            }
            copy($default_path, '../media/img_users/'.$user.'/no_cover.jpg');
            rename('../media/img_users/'.$user.'/no_cover.jpg', '../media/img_users/'.$user.'/'.$user.'lista'.$num_playlist.'.jpg');
            $new_path = '../media/img_users/'.$user.'/'.$user.'lista'.$num_playlist.'.jpg';
        }  
        

        $crear = $con->prepare("INSERT INTO playlists (title, image, pl_date, user) values (?,?,?,?)");
        $crear->bind_param('sssi', $name, $new_path, $date, $id);
        $crear->execute();
        $con->close();