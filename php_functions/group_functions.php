<?php
    require_once "general.php";
    require "../PHP Duracion script/AudioMP3Class.php";

    function getGroupNameByMail($mail){
        $con = createConnection();
        $query = $con->prepare("SELECT name from artist where mail = ?");
        $query->bind_param('s', $mail);
        $query->bind_result($name);
        $query->execute();
        $query->fetch();
        $query->close();
        $con->close();
        return $name;
    }

    function checkInformationCompleted($mail){
        $complete = false;

        $con = createConnection();
        $query = $con->prepare("SELECT bio, image, avatar from artist where mail = ?");
        $query->bind_param("s", $mail);
        $query->bind_result($bio, $image, $avatar);
        $query->execute();
        $query->fetch();
        $query->close();
        $con->close();
        if(($bio !== NULL and $image!== NULL and $avatar !== NULL) and ($bio != "" and $image != "" and $avatar != "")){
            $complete = true;
        }
        return $complete;
    }

    function getAlbumName($id, $mail){
        $con = createConnection();
        $query = $con->prepare("SELECT title from album a, artist g where a.artist = g.id and a.id = ? and g.mail = ?");
        $query->bind_param('is', $id, $mail);
        $query->bind_result($title);
        $query->execute();
        $query->fetch();
        $query->close();
        $con->close();
        return $title;
    }

    function totalAlbumReviews($id){
        $con = createConnection();
        $query = $con->prepare("SELECT count(*) from review where album = ?");
        $query->bind_param('i', $id);
        $query->bind_result($total);
        $query->execute();
        $query->fetch();
        $query->close();
        $con->close();
        return $total;
    }

    function activeFormat($active){
        return $active == 0 ? '<span class="inactive-state">Inactivo. <a class="text-white text-decoration-underline" href="../contacto/contacto.php">Contáctenos</a></span>' : '<span class="active-state">Activo</span>';
    }

    function getGroupAlbums($mail){
        $con = createConnection();
        $query = $con->prepare("SELECT title, a.picture picture, release_date, a.id id, a.active active from album a, artist g where a.artist = g.id and mail = ?");
        $query->bind_param('s', $mail);
        $query->bind_result($title, $picture, $date, $id, $active);
        $query->execute();
        $query->store_result();
        if($query->num_rows > 0){
            $counter = 0;
            while($query->fetch()){
                $state = activeFormat($active);
                $total_reviews = totalAlbumReviews($id);
                $release_date = formatDate($date);
                echo "<div class='border rounded p-2 album-container-group-main d-flex flex-column flex-lg-row align-items-center align-items-lg-start justify-content-center gap-3'>
                        <img class='rounded' src='$picture'>
                        <div class='w-50 d-flex flex-column gap-3 justify-content-between h-100'>
                            <h5>$title</h5>
                            <h5>Lanzado el $release_date</h5>
                            <h5>Reseñas recibidas: $total_reviews</h5>
                            $state
                        </div></div>";
                // if($counter+1 % 3 == 0){
                //     echo "</div>";
                // }
                // $counter++;
            }
        }else{
            echo "<h2 class='mt-3 mb-5'>No hay discos publicados por el momento</h2>";
        }
        $query->close();
        $con->close();
    }

    function getGroupInfo($mail){
        $con = createConnection();
        $query = $con->prepare("SELECT name, image, pass, mail, avatar, bio from artist where mail = ?");
        $query->bind_param('s', $mail);
        $query->bind_result($name, $image, $pass, $mail, $avatar, $bio);
        $query->execute();
        $query->fetch();
        echo "<section class='banner-group-main mb-5 pb-3' data-bg='$image'>
                <div class='position-relative'>
                    <a class='banner-group-main-avatar-link' href=''>
                        <img class='banner-group-main-avatar rounded-circle' src='$avatar'>
                        <ion-icon class='icon-edit-avatar-group d-none' name=\"pencil-outline\"></ion-icon>
                    </a>
                    
                    <button style='--clr:#c49c23' class='btn-danger-own banner-group-main-photo-link'><span>Editar</span><i></i></button>
                </div>
            </section>
            <section class='d-flex flex-column align-items-center justify-content-center pt-4'>
                <h1 class='text-center'>$name</h1>
                <section class='group-main-info container-xl d-flex flex-column flex-md-row align-items-center align-items-md-start gap-5 mt-5 mb-5'>
                    <div class='w-50'>
                        <form action='#' method='post'>
                            <legend class='text-center'>Biografía</legend>
                            <div class='d-flex justify-content-center mb-4'>
                                <ion-icon id='edit-biografia-grupo' name=\"pencil-outline\"></ion-icon>
                            </div>
                            <textarea name='bio' class='w-100' rows='20' cols='60' disabled>$bio</textarea>
                            <button hidden style='--clr:#c49c23' class='btn-danger-own mt-3' name='actualizar-bio'><span>Actualizar</span><i></i></button>
                        </form>
                    </div>
                    <div class='w-50'>
                        <form class='form-edit-datos-grupo' action='#' method='post'>
                            <legend class='text-center'>Datos de grupo</legend>
                            <div class='d-flex justify-content-center mb-2'>
                                <ion-icon id='edit-datos-grupo' name=\"pencil-outline\"></ion-icon>
                            </div>
                            <div class=\"input-field d-flex flex-column mb-3\">
                                <div class=\"input-visuals d-flex justify-content-between\">
                                    <label for=\"mail\">Correo electrónico (para cambiar su correo contacte con los administradores)</label>
                                    <ion-icon name=\"mail-outline\"></ion-icon>
                                </div>
                                <input disabled readonly value='$mail' name=\"mail\" type=\"email\">                        
                            </div>
                            <div class=\"input-field d-flex flex-column mb-3\">
                                <div class=\"input-visuals d-flex justify-content-between\">
                                    <label for=\"pass\">Contraseña</label>
                                    <ion-icon name=\"person-outline\"></ion-icon>
                                </div>
                                <input disabled name=\"pass\" type=\"password\">
                                <input class='pass-original' hidden value='$pass' name='pass-original'>                        
                            </div>
                            
                            <button hidden style='--clr:#c49c23' class='btn-danger-own actualizar-datos-submit' name='actualizar-datos'><span>Actualizar</span><i></i></button>
                        </form>
                    </div>
                </section>
            <section class=\"update-avatar-photo d-none flex-column justify-content-center align-items-center\">
                <ion-icon class='close-modal-update-avatar position-absolute' name=\"close-outline\"></ion-icon>
                <img class='rounded-circle w-25' src=\"$avatar\" alt=\"\">
                <form class='text-center' action=\"#\" method=\"post\" enctype=\"multipart/form-data\">
                    <div class=\"input-field  mb-3 gap-2\">
                        <div class=\" justify-content-between\">
                            <label class=\"file\">Foto de avatar del grupo</label>
                            <ion-icon name=\"image-outline\"></ion-icon>
                            <input type=\"file\" class=\"custom-file-input\" name=\"foto-avatar-nueva\">
                        </div>
                    </div>
                    <button style='--clr:#c49c23' class='btn-danger-own' name='actualizar-avatar'><span>Actualizar foto de avatar</span><i></i></button>
                    
                </form>
            </section>
            <section class=\"update-main-photo d-none flex-column justify-content-center align-items-center\">
                <ion-icon class='close-modal-update-main-photo position-absolute' name=\"close-outline\"></ion-icon>
                <img class='rounded w-50' src=\"$image\" alt=\"\">
                <form class='text-center' action=\"#\" method=\"post\" enctype=\"multipart/form-data\">
                    <div class=\"input-field  mb-3 gap-2\">
                        <div class=\" justify-content-between\">
                            <label class=\"file\">Foto principal del grupo</label>
                            <ion-icon name=\"image-outline\"></ion-icon>
                            <input type=\"file\" class=\"custom-file-input\" name=\"foto-nueva\">
                        </div>
                    </div>
                    <button style='--clr:#c49c23' class='btn-danger-own' name='actualizar-foto'><span>Actualizar foto principal</span><i></i></button>
                </form>
            </section>
            <section class='container-fluid'>
                <h2 class='text-center text-decoration-underline mb-4'>Discos publicados</h2>
                <section class='d-flex flex-column flex-xl-row container-fluid gap-5 flex-wrap justify-content-center'>";
                getGroupAlbums($mail);
            echo "</section>
                </section>";
        $query->close();
        $con->close();
    }

    function updateAvatarPhoto($mail, $avatar){
        $con = createConnection();
        $update = $con->prepare("UPDATE artist set avatar = ? where mail = ?");
        $update->bind_param('ss', $avatar, $mail);
        $update->execute();
        $update->close();
        $con->close();
    }

    function updateMainPhoto($mail, $image){
        $con = createConnection();
        $update = $con->prepare("UPDATE artist set image = ? where mail = ?");
        $update->bind_param('ss', $image, $mail);
        $update->execute();
        $update->close();
        $con->close();
    }

    // function getGroupInfo2($mail){
    //     $con = createConnection();
    //     $query = $con->prepare("SELECT nombre, foto, foto_avatar, biografia from grupo where correo = ?");
    //     $query->bind_param('s', $mail);
    //     $query->bind_result($nombre, $foto, $foto_avatar, $bio);
    //     $query->execute();
    //     $query->fetch();
    //     echo "<section class='banner-group-main' data-bg='$foto'><img class='img-fluid' src='$foto'><img src='$foto_avatar'></section>";
    //     $query->close();
    //     $con->close();
    // }

    function getStyles(){
        $con = createConnection();
        $query = $con->prepare("SELECT name, id FROM styles where id <> 0");
        $query->bind_result($name, $id);
        $query->execute();
        while($query->fetch()) {
            echo "<option class=\"p-2\" value=\"$id\">$name</option>";
        }
        $query->close();
        $con->close();
    }

    function menuGrupoDropdown($position = "position-absolute"){
        echo "<header class=\"dropdown-header d-flex justify-content-between align-items-center pt-3 pe-3 pb-2 ps-3 $position w-100\">
                <a class=\"dropdown-link-responsive\" href=\"../index.php\"><img src=\"../media/assets/sonic-waves-logo-simple.png\"></a>
                <a href=\"../index.php\"><img class=\"w-25\" src=\"../media/assets/sonic-waves-high-resolution-logo-color-on-transparent-background (1).png\"></a>
                <div class=\"dropdown-admin-disc-group\">
                    <button class=\"btn btn-secondary btn-lg dropdown-toggle\" type=\"button\" data-bs-toggle=\"dropdown\" aria-expanded=\"false\">
                    Menú de grupo
                    </button>
                    <ul class=\"dropdown-menu\">
                        <li><a class=\"dropdown-item\" href=\"grupo_main.php\">Portada</a></li>
                        <li><a class=\"dropdown-item\" href=\"artist_new_album.php\">Subir nuevo álbum</a></li>
                        <li><a class=\"dropdown-item\" href=\"artist_new_post.php\">Añadir publicación</a></li>
                        <li><a class=\"dropdown-item\" href=\"artist_reviews.php\">Reseñas de mis álbumes</a></li>
                        <li><a class=\"dropdown-item\" href=\"artist_members.php\">Miembros de grupo</a></li>
                        <li><a class=\"dropdown-item\" href=\"group_messages.php\">Mis mensajes</a></li>
                        <li><form action=\"#\" method=\"post\"><input class='dropdown-item' id=\"cerrar-user\" type=\"submit\" name=\"cerrar-sesion\" value=\"Cerrar sesión\"></form></li>
                    </ul>
                </div>
              </header>";
    }

    function completeInformation($mail, $bio, $image, $avatar){
        $con = createConnection();
        $actualizacion = $con->prepare("UPDATE artist SET bio = ?, image = ?, avatar = ? WHERE artist = ?");
        $actualizacion->bind_param("ssss", $bio, $image, $avatar, $mail);
        $actualizacion->execute();
        $actualizacion->close();
        $con->close();
    }

    function checkPhoto($name){
        $correct = false;
        $format = $_FILES[$name]["type"];
        $size = $_FILES[$name]["size"];
        $size_mb = $size / pow(1024, 2);

        if($size_mb < 10 and ($format == "image/jpeg" or $format == "image/png" or $format == "image/gif" or $format == "image/webp")){
            $correct = true;
        }
        return $correct;
    }

    function newPhotoPath($name, $type, $user){
        $new_name = "";
        switch($_FILES[$name]["type"]){
            case "image/jpeg":
                $new_name = $user.$type.".jpg";
                break;
            case "image/png":
                $new_name = $user.$type.".png";
                break;
            case "image/gif":
                $new_name = $user.$type.".gif";
                break;
            case "image/webp":
                $new_name = $user.$type.".webp";
                break;
        }
        if(!file_exists("../media/img_grupos/".$user)){
            mkdir("../media/img_grupos/".$user, 0777, true);
        }
        $new_path = "../media/img_grupos/".$user."/".$new_name;
        move_uploaded_file($_FILES[$name]["tmp_name"], $new_path);
        return $new_path;
    }
    
    function removeSpecialCharacters($name){
        $remove = ["/", "*","'","[","]", "?", "(", ")"];
        $fixed = strtolower(str_replace($remove, "", $name));
        return $fixed;
    }
    function newPhotoPathAlbum($name, $album, $user){
        $new_name = "";
        $remove = ["/", ".", "*","'",":", "?", "(", ")"];
        $album = strtolower(str_replace($remove, "", $album));

        switch($_FILES[$name]["type"]){
            case "image/jpg":
                $new_name = $album.".jpg";
                break;
            case "image/jpeg":
                $new_name = $album.".jpg";
                break;
            case "image/png":
                $new_name = $album.".png";
                break;
            case "image/gif":
                $new_name = $album.".gif";
                break;
            case "image/webp":
                $new_name = $album.".webp";
                break;
        }
        if(!file_exists("../media/img_grupos/".$user)){
            mkdir("../media/img_grupos/".$user, 0777, true);
        }

        $new_path = "../media/img_grupos/".$user."/".$new_name;
        move_uploaded_file($_FILES[$name]["tmp_name"], $new_path);
        return $new_path;
    }

    function addAlbum($artist, $name, $picture, $release_date, $active){
        $con = createConnection();
        $insercion = $con->prepare("INSERT INTO album (title,picture,active,artist,release_date) values (?, ?, ?, ?, ?)");
        $insercion->bind_param('ssiis', $name, $picture, $active, $artist, $release_date);
        $insercion->execute();
        $insercion->close();
        $con->close();
    }

    function getGroupID($mail){
        $con = createConnection();
        $query = $con->prepare("SELECT id from artist where mail = ?");
        $query->bind_param('s', $mail);
        $query->bind_result($id);
        $query->execute();
        $query->fetch();
        $query->close();
        $con->close();
        return $id;
    }
    
    function getAllGroupSongs($id){
        $con = createConnection();
        $query = $con->prepare("SELECT distinct c.id song_id, c.title title from artist g, album a, song c, album_contains i where a.artist = g.id and i.song = c.id and i.album = a.id and g.id = ?");
        $query->bind_param('i', $id);
        $query->bind_result($id, $song);
        $query->execute();
        while($query->fetch()){
            echo "<option value=\"$id\">$song</option>";
        }
        $query->close();
        $con->close();
    }

    function generateInputs($num){
        $counter = 1;
        echo "<ul class='song-adder-list d-flex flex-column gap-5'>";
        while($counter <= $num){
            $name = "titulo".$counter;
            $name2 = "archivo".$counter;
            $name3 = "estilo".$counter;
            echo "<li><div class='input-field'>
                    <label for=\"\">Título</label>
                    <input required type=\"text\" name=\"$name\">
                    <label for=\"\">Archivo</label>
                    <input required accept=\".mp3\" type=\"file\" name=\"$name2\">
                    <label for=\"estilo\">Estilo de la canción</label>
                    <select required name=\"$name3\">";
                    getStyles();
                    echo "</select>
                 </div></li>";
            $counter++;
        }
        echo "</ul>
                <button name='cargar' style='--clr:#c49c23' class='btn-danger-own'><span>Cargar álbum</span><i></i></button>";
    }

    function generateSelects($num, $id){
        $counter = 1;
        echo "<ul class='selects-container'>";
        while($counter <= $num){
            $name = "cancion".$counter;
            echo "<li><select required name=\"$name\"><option value='' hidden>Elige una canción</option>";
                getAllGroupSongs($id);
                 echo "</select></li>";
            $counter++;
        }
        echo "</ul><button name='cargar' style='--clr:#c49c23' class='btn-danger-own'><span>Cargar álbum</span><i></i></button>";
    }

    function getDuration($song){
        $mp3file = new MP3File($song);
        $duration_seconds = $mp3file->getDurationEstimate();
        $minutes = MP3File::formatTime($duration_seconds);
        return $minutes;
    }

    function addSong($title, $file, $length, $style){
        $con = createConnection();
        $insert = $con->prepare("INSERT INTO songs (title,length,file,style) values (?,?,?,?)");
        $insert->bind_param('sssi', $title, $length, $file, $style);
        $insert->execute();
        $rows = $insert->affected_rows;
        $insert->close();
        $con->close();
        return $rows;
    }

    function linkSongToAlbum($album, $song){
        $con = createConnection();
        $insert = $con->prepare("INSERT INTO album_contains (album,song) values (?,?)");
        $insert->bind_param('ii', $album, $song);
        $insert->execute();
        $rows = $insert->affected_rows;
        $insert->close();
        $con->close();
        return $rows;
    }

    function moveUploadedSong($name, $artist, $album){
        $album = removeSpecialCharacters($album);
        if(!file_exists("../media/audio/$artist")){
            mkdir("../media/audio/$artist");
        }
        // echo $album;
        // echo $_SERVER['DOCUMENT_ROOT']."/SonicWaves/media/audio/$artist/$album";
        if(!file_exists("../media/audio/$artist/$album")){
            if(!mkdir("../media/audio/$artist/$album")){
                echo "Error, no se pudo crear la carpeta $artist $album";
            }
        }
        $song = $_FILES[$name]["name"];
        $song = removeSpecialCharacters($song);
        $new_path = "../media/audio/$artist/$album/$song";
        move_uploaded_file($_FILES[$name]["tmp_name"], $new_path);
        return $new_path;
    }

    function getLastSongID(){
        $con = createConnection();
        $query = $con->query("SELECT id from songs order by id desc limit 1");
        $row = $query->fetch_array(MYSQLI_ASSOC);
        $id = $row["id"];
        return $id;
    }

    function getGroupName($id){
        $con = createConnection();
        $query = $con->prepare("SELECT name from artist where id = ?");
        $query->bind_param('i', $id);
        $query->bind_result($name);
        $query->execute();
        $query->fetch();
        $query->close();
        $con->close();
        return $name;
    }

    function updateBio($mail, $bio){
        $con = createConnection();
        $update = $con->prepare("UPDATE artist set bio = ? where mail = ?");
        $update->bind_param('ss', $bio, $mail);
        $update->execute();
        $update->close();
        $con->close();
    }

    // function emailRepeatedAtUpdate($mail, $mail_act){
    //     $con = createConnection();
    //     $query = $con->prepare("SELECT count(*) from grupo where correo = ? or correo = ?");
    //     $query->bind_param('ss', $mail, $mail_act);
    //     $query->bind_result($count);
    //     $query->execute();
    //     $query->fetch();
    //     $query->close();
    //     $con->close();
    //     return $count;
    // }

    function updateGroupData($user, $pass){
        $con = createConnection();
        $update = $con->prepare("UPDATE artist set pass = ? where mail = ?");
        $update->bind_param('ss', $pass, $user);
        $update->execute();
        $update->close();
        $con->close();
    }

    function addPost($mail, $title, $content, $image, $p_date){
        $con = createConnection();
        $id = getGroupID($mail);
        $insert = $con->prepare("INSERT into posts (title, content, image, p_date, artist) values (?,?,?,?,?)");
        $insert->bind_param('ssssi', $title, $content, $image, $p_date, $id);
        $insert->execute();
        $insert->close();
        $con->close();
    }

    function checkPhotosArray($name, $index){
        $correct = false;
        $format = $_FILES[$name]["type"][$index];
        $size = $_FILES[$name]["size"][$index];
        $size_mb = $size / pow(1024, 2);

        if($size_mb < 10 and ($format == "image/jpeg" or $format == "image/png" or $format == "image/gif" or $format == "image/webp")){
            $correct = true;
        }
        return $correct;
    }

    function newPhotoPathPost($type, $index_image, $id_post, $original_path, $user){
        $new_name = "";
        // $quitar = ["/", ".", "*","'"];
        // $album = strtolower(str_replace($quitar, "", $album));

        switch($type){
            case "image/jpeg":
                $new_name = "foto".$index_image."post".$id_post.".jpg";
                break;
            case "image/png":
                $new_name = "foto".$index_image."post".$id_post.".png";
                break;
            case "image/gif":
                $new_name = "foto".$index_image."post".$id_post.".gif";
                break;
            case "image/webp":
                $new_name = "foto".$index_image."post".$id_post.".webp";
                break;
        }
        if(!file_exists("../media/img_posts/".$user)){
            mkdir("../media/img_posts/".$user, 0777, true);
        }
        $new_path = "../media/img_posts/".$user."/".$new_name;
        move_uploaded_file($original_path, $new_path);
        return $new_path;
    }

    function newMainPhotoPathPost($id_post, $user){
        $new_name = "";
        // $quitar = ["/", ".", "*","'"];
        // $album = strtolower(str_replace($quitar, "", $album));

        switch($_FILES["foto"]["type"]){
            case "image/jpeg":
                $new_name = "fotoPrincipalpost".$id_post.".jpg";
                break;
            case "image/png":
                $new_name = "fotoPrincipalpost".$id_post.".png";
                break;
            case "image/gif":
                $new_name = "fotoPrincipalpost".$id_post.".gif";
                break;
            case "image/webp":
                $new_name = "fotoPrincipalpost".$id_post.".webp";
                break;
        }
        if(!file_exists("../media/img_posts/".$user)){
            mkdir("../media/img_posts/".$user, 0777, true);
        }
        $new_path = "../media/img_posts/".$user."/".$new_name;
        move_uploaded_file($_FILES["foto"]["tmp_name"], $new_path);
        return $new_path;
    }

    function addPostPhotos($link, $post){
        $con = createConnection();
        $insert = $con->prepare("INSERT INTO post_photos (link, post) values (?, ?)");
        $insert->bind_param('si', $link, $post);
        $insert->execute();
    }

    function newGroupPhotoPath($num, $type, $tmp, $user){
        $new_name = "";
        switch($type){
            case "image/jpeg":
                $new_name = $user."fotoextra".$num.".jpg";
                break;
            case "image/png":
                $new_name = $user."fotoextra".$num.".png";
                break;
            case "image/gif":
                $new_name = $user."fotoextra".$num.".gif";
                break;
            case "image/webp":
                $new_name = $user."fotoextra".$num.".webp";
                break;
        }
        if(!file_exists("../media/img_grupos/".$user)){
            mkdir("../media/img_grupos/".$user, 0777, true);
        }
        $new_path = "../media/img_grupos/".$user."/".$new_name;
        move_uploaded_file($tmp, $new_path);
        return $new_path;
    }

    function addGroupExtraPhoto($image, $artist){
        $con = createConnection();
        $insert = $con->prepare("INSERT INTO artist_photos (link, artist) values (?,?)");
        $insert->bind_param('si', $image, $artist);
        $insert->execute();
        $insert->close();
        $con->close();
    }

    function checkPhotoLimit($user){
        $con = createConnection();
        $id = getGroupID($user);
        $query = $con->prepare("SELECT count(*) from artist_photos where artist = ?");
        $query->bind_param('i', $id);
        $query->bind_result($count);
        $query->execute();
        $query->fetch();
        $query->close();
        $con->close();
        return $count;
    }

    function getGroupExtraPhotos($user){
        $con = createConnection();
        $id = getGroupID($user);
        $query = $con->prepare("SELECT id, link from artist_photos where artist = ?");
        $query->bind_param('i', $id);
        $query->bind_result($id, $link);
        $query->execute();
        $query->store_result();
        if($query->num_rows > 0){
            while($query->fetch()){
                echo "<form action='#' method='post' class='position-relative'>
                        <img src='$link' class='img-fluid object-fit-cover'>
                        <input hidden value='$id' name='id-foto'>
                        <button style='--clr:#e80c0c' class='btn-danger-own position-absolute' name='eliminar-foto'><span>Eliminar</span><i></i></button>
                     </form>";
            }
        }else{
            echo "<div class=\"alert no-f alert-warning mt-3\" role=\"alert\">Sin fotos extra</div>";
        }
        $query->close();
        $con->close();
    }

    function getPhotoLink($id){
        $con = createConnection();
        $query = $con->prepare("SELECT link from artist_photos where id = ?");
        $query->bind_param('i', $id);
        $query->bind_result($link);
        $query->execute();
        $query->fetch();
        $query->close();
        $con->close();
        return $link;
    }

    function deletePhoto($id){
        $link = getPhotoLink($id);
        $con = createConnection();
        $delete = $con->prepare("DELETE FROM artist_photos where id = ?");
        $delete->bind_param('i', $id);
        $delete->execute();
        $delete->close();
        $con->close();
        unlink($link);
    }

    function checkEnoughAlbumsGroup($id_artist){
        $con = createConnection();
        $query = $con->query("SELECT count(*) total from album a, artist g where a.artist = g.id and g.id = $id_artist");
        $row = $query->fetch_array(MYSQLI_ASSOC);
        $total = $row["total"];
        $con->close();
        return $total;
    }

    function getAlbumsWithReviews($mail){
        $con = createConnection();
        $query = $con->prepare("SELECT a.picture picture, title, a.id id from album a, artist g where a.artist = g.id and g.mail = ?");
        $query->bind_param('s', $mail);
        $query->bind_result($picture, $title, $id);
        $query->execute();
        while($query->fetch()){
            $total_reviews = totalAlbumReviews($id);
            echo "<div class='d-flex gap-3 align-items-center rounded album-review-group-container'>
                    <div class='album-review-container-img'>
                        <img src='$picture' class='img-fluid'>
                        <canvas></canvas>
                    </div>
                    <div class='d-flex flex-column gap-1'>
                        <h4 class='mt-0'>$title</h4>
                        <h4>Reseñas totales: $total_reviews</h4>
                    ";
            if($total_reviews != 0){
                echo "<form action='artist_album_reviews.php' method='get'>
                        <input hidden name='id' value='$id'>
                        <button style='--clr:#e80c0c' class='btn-danger-own' name='ver-reseñas'><span>Ver reseñas</span><i></i></button></div></div>
                    </form>";
            }else{
                echo "</div></div>";
            }
                
        }
        $query->close();
        $con->close();
    }

    function getAllReviewsOfAlbum($id){
        $con = createConnection();
        $query = $con->prepare("SELECT title, content, r_date, avatar from review r, user u where r.user = u.id and album = ?");
        $query->bind_param('i', $id);
        $query->bind_result($title, $content, $r_date, $avatar);
        $query->execute();
        $query->store_result();

        if($query->num_rows > 0){
            while($query->fetch()){
                $r_date = formatDate($r_date);
                echo "<div class='d-flex flex-column gap-3 review-individual-container-group-section'>
                        <div class='d-flex align-items-center gap-2'>
                            <img src='$avatar' class='rounded-circle'>
                            <h2 class='m-0'>$title</h2>
                        </div>
                        <p>$content</p>
                        <i>Reseña escrita el $r_date</i>
                    </div>";
            }
        }else{
            echo "<h3>No hay reseñas escritas aún</h3>";
        }
        
        $query->close();
        $con->close();
    }

    function groupHasMembers($mail){
        $id = getGroupID($mail);
        $con = createConnection();
        $query = $con->prepare("SELECT count(*) from user where artist = ?");
        $query->bind_param('i', $id);
        $query->bind_result($members);
        $query->execute();
        $query->fetch();
        $query->close();
        $con->close();
        return $members;
    }

    function userExists($user){
        $con = createConnection();
        $query = $con->prepare("SELECT count(*) from user where username = ?");
        $query->bind_param('s', $user);
        $query->bind_result($exists);
        $query->execute();
        $query->fetch();
        $query->close();
        $con->close();
        return $exists;
    }

    function userIsMember($user){
        $con = createConnection();
        $query = $con->prepare("SELECT artist from user where username = ?");
        $query->bind_param('s', $user);
        $query->bind_result($is_member);
        $query->execute();
        $query->fetch();
        $query->close();
        $con->close();
        return $is_member;
    }
    
    function addNewMember($user, $mail){
        $group_id = getGroupID($mail);
        $con = createConnection();
        $insert = $con->prepare("UPDATE user set artist = ? where username = ?");
        $insert->bind_param('is', $group_id, $user);
        $insert->execute();
        $insert->close();
        $con->close();
    }
    
    function removeMember($user){
        $deleted = false;
        $con = createConnection();
        $update = $con->prepare("UPDATE user set artist = 0 where id = ?");
        $update->bind_param('i', $user);
        $update->execute();
        if($update){
            $deleted = true;
        }
        $update->close();
        $con->close();
        return $deleted;
    }
    
    function getGroupMembers($mail){
        $id = getGroupID($mail);
        $con = createConnection();
        $query = $con->prepare("SELECT username, avatar, id from user where artist = ?");
        $query->bind_param('i', $id);
        $query->bind_result($user, $avatar, $id_user);
        $query->execute();
        while($query->fetch()){
            echo "<div class='d-flex align-items-center gap-3'>
                    <img src='$avatar' class='group-member-avatar img-fluid rounded-circle'>
                    <h3 class='m-0'>$user</h3>
                    <form action='#' method='post'>
                        <input hidden value='$id_user' name='usuario'>
                        <button style='--clr:#dc143c' class='btn-danger-own' name='eliminar-miembro'><span>Eliminar</span><i></i></button>
                    </form>
                  </div>";
        }
        $query->close();
        $con->close();
    }

    function getGroupMembersIDs($id){
        $con = createConnection();
        $ids = [];
        $query = $con->prepare("SELECT id from user where artist = ?");
        $query->bind_param('i', $id);
        $query->bind_result($id_member);
        $query->execute();
        $query->store_result();
        if($query->num_rows > 0){
            $index = 0;
            while($query->fetch()){           
                $ids[$index] = $id_member;
                $index++;
            }
        }
       
        $query->close();
        $con->close();
        return $ids;
    }

    function sendMessage($msg, $mail){
        $message_sent = false;
        $id_group = getGroupID($mail);
        $date = date('Y-m-d H:i:s');
        $con = createConnection();
        $query = $con->prepare("INSERT INTO group_messages values ('', ?,?,?)");
        $query->bind_param('ssi', $msg, $date, $id_group);
        if($query->execute()){
            $queryid = $con->query("SELECT id from group_messages order by id desc");
            $row = $queryid->fetch_array(MYSQLI_ASSOC);
            $id = $row["id"];
            $query->close();
            $members = getGroupMembersIDs($id_group);
            foreach($members as $member){
                $link_message = $con->query("INSERT INTO member_receives_message (user, message) values ($member, $id)");
            }
            $message_sent = true;
        }
        $con->close();    
        return $message_sent;
    }

    function getMessagesWithPatrons($mail){
        $con = createConnection();
        $query = $con->prepare("SELECT DISTINCT p.avatar avatar, p.name name, p.id id from patrons p, patrons_messages pm, artist g where p.id = pm.patron and g.id = pm.artist and
        g.mail = ?");
        $query->bind_param('s', $mail);
        $query->bind_result($avatar, $name, $id);
        $query->execute();
        while($query->fetch()){
            echo "<div class='d-flex gap-3 align-items-center rounded album-review-group-container'>
                    <div class='album-review-container-img'>
                        <img src='$avatar' class='img-fluid'>
                        <canvas></canvas>
                    </div>
                    <div class='d-flex flex-column gap-1'>
                        <h4 class='mt-0'>$name</h4>
                    ";
                echo "<form action='group_message.php' method='get'>
                        <input hidden name='patron' value='$id'>
                        <button style='--clr:#e80c0c' class='btn-danger-own'><span>Abrir mensajes</span><i></i></button></div></div>
                    </form>";          
        }
        $query->close();
        $con->close();
    }

    function retrieveMesagesWithPatron($mail, $id_patron){
        $con = createConnection();
        $query = $con->prepare("SELECT content, receiver, sender, m_date, p.name patron_name, g.name group_name from patrons_messages pm, patrons p, artist g where pm.patron = p.id and p.id = ? and g.id = pm.artist and
        g.mail = ? order by m_date desc");
        $query->bind_param('is', $id_patron, $mail);
        $query->bind_result($content, $receiver, $sender, $date, $patron_name, $group_name);
        $query->execute();
        $query->store_result();

        if($query->num_rows > 0){
            while($query->fetch()){
                $date_split = explode(" ", $date);
                $date_format = formatDate($date_split[0]);
                if($receiver == "artist"){
                    echo "<div class='sender-artist p-3'>
                        <p>$content</p>
                        <span>Enviado el $date_format a las $date_split[1] por $patron_name<span>
                    </div>";
                }else{
                    echo "<div class='sender-patron p-3'>
                        <p>$content</p>
                        <span>Enviado el $date_format a las $date_split[1] por $group_name<span>
                    </div>";
                }
            }
            echo "<form action='#' method='post' class='d-flex flex-column gap-3'>
                    <input type='text' placeholder='Escribe tu respuesta' name='msg'>
                    <input hidden name='id-patron' value='$id_patron'>
                    <button style='--clr:#0fcc0c' class='btn-danger-own align-self-center' name='send-answer'><span>Enviar mensaje</span><i></i></button></div></div>
                  </form>";
        }else{
            echo "<h2 class='text-center'>No hay mensajes con este artista</h2>";
        }
        $query->close();
        $con->close();
    }

    function sendMessageToPatron($msg, $user, $id_patron){
        $message_sent = false;
        $group_id = getGroupID($user);
        $msg = strip_tags($msg);
        $sender = "artist";
        $receiver = "patron";
        $date = date('Y-m-d H:i:s');
        $con = createConnection();
        $query = $con->prepare("INSERT INTO patrons_messages values ('', ?,?,?,?,?,?)");
        $query->bind_param('ssssii', $sender, $receiver, $msg, $date, $id_patron, $group_id);
        if($query->execute()){
            // $queryid = $con->query("SELECT id from patrons_messages order by id desc");
            // $row = $queryid->fetch_array(MYSQLI_ASSOC);
            // $id = $row["id"];
            // $query->close();
            // $link_message = $con->query("INSERT INTO artist_receives_message (artist, message) values ($group_id, $id)");
            $message_sent = true;
        }
        $con->close();    
        return $message_sent;
    }
 
?>
