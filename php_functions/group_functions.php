<?php
    require_once "general.php";
    require "../PHP Duracion script/AudioMP3Class.php";

    function getGroupNameByMail($mail){
        $con = createConnection();
        $consulta = $con->prepare("SELECT nombre from grupo where correo = ?");
        $consulta->bind_param('s', $mail);
        $consulta->bind_result($nombre);
        $consulta->execute();
        $consulta->fetch();
        $consulta->close();
        $con->close();
        return $nombre;
    }

    function checkInformationCompleted($mail){
        $completo = false;

        $con = createConnection();
        $consulta = $con->prepare("SELECT biografia, foto, foto_avatar from grupo where correo = ?");
        $consulta->bind_param("s", $mail);
        $consulta->bind_result($bio, $foto, $foto_avatar);
        $consulta->execute();
        $consulta->fetch();
        $consulta->close();
        $con->close();
        if(($bio !== NULL and $foto!== NULL and $foto_avatar !== NULL) and ($bio != "" and $foto != "" and $foto_avatar != "")){
            $completo = true;
        }
        return $completo;
    }

    function getAlbumName($id, $mail){
        $con = createConnection();
        $consulta = $con->prepare("SELECT titulo from album a, grupo g where a.grupo = g.id and a.id = ? and g.correo = ?");
        $consulta->bind_param('is', $id, $mail);
        $consulta->bind_result($titulo);
        $consulta->execute();
        $consulta->fetch();
        $consulta->close();
        $con->close();
        return $titulo;
    }

    function totalAlbumReviews($id){
        $con = createConnection();
        $consulta = $con->prepare("SELECT count(*) from reseña where album = ?");
        $consulta->bind_param('i', $id);
        $consulta->bind_result($total);
        $consulta->execute();
        $consulta->fetch();
        $consulta->close();
        $con->close();
        return $total;
    }

    function activeFormat($activo){
        return $activo == 0 ? '<span class="inactive-state">Inactivo. <a class="text-white text-decoration-underline" href="../contacto/contacto.php">Contáctenos</a></span>' : '<span class="active-state">Activo</span>';
    }

    function getGroupAlbums($mail){
        $con = createConnection();
        $consulta = $con->prepare("SELECT titulo, a.foto foto, lanzamiento, a.id id, a.activo activo from album a, grupo g where a.grupo = g.id and correo = ?");
        $consulta->bind_param('s', $mail);
        $consulta->bind_result($titulo, $foto, $lanzamiento, $id, $activo);
        $consulta->execute();
        $consulta->store_result();
        if($consulta->num_rows > 0){
            $counter = 0;
            while($consulta->fetch()){
                $estado = activeFormat($activo);
                $total_reviews = totalAlbumReviews($id);
                $fecha = formatDate($lanzamiento);
                echo "<div class='border rounded p-2 album-container-group-main d-flex flex-column flex-lg-row align-items-center align-items-lg-start justify-content-center gap-3'>
                        <img class='rounded' src='$foto'>
                        <div class='w-50 d-flex flex-column gap-3 justify-content-between h-100'>
                            <h5>$titulo</h5>
                            <h5>Lanzado el $fecha</h5>
                            <h5>Reseñas recibidas: $total_reviews</h5>
                            $estado
                        </div></div>";
                // if($counter+1 % 3 == 0){
                //     echo "</div>";
                // }
                // $counter++;
            }
        }else{
            echo "<h2 class='mt-3 mb-5'>No hay discos publicados por el momento</h2>";
        }
        $consulta->close();
        $con->close();
    }

    function getGroupInfo($mail){
        $con = createConnection();
        $consulta = $con->prepare("SELECT nombre, foto, pass, correo, foto_avatar, biografia from grupo where correo = ?");
        $consulta->bind_param('s', $mail);
        $consulta->bind_result($nombre, $foto, $pass, $correo, $foto_avatar, $bio);
        $consulta->execute();
        $consulta->fetch();
        echo "<section class='banner-group-main mb-5 pb-3' data-bg='$foto'>
                <div class='position-relative'>
                    <a class='banner-group-main-avatar-link' href=''>
                        <img class='banner-group-main-avatar rounded-circle' src='$foto_avatar'>
                        <ion-icon class='icon-edit-avatar-group d-none' name=\"pencil-outline\"></ion-icon>
                    </a>
                    
                    <button style='--clr:#c49c23' class='btn-danger-own banner-group-main-photo-link'><span>Editar</span><i></i></button>
                </div>
            </section>
            <section class='d-flex flex-column align-items-center justify-content-center pt-4'>
                <h1 class='text-center'>$nombre</h1>
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
                                    <label for=\"mail\">Correo electrónico</label>
                                    <ion-icon name=\"mail-outline\"></ion-icon>
                                </div>
                                <input disabled value='$correo' name=\"mail\" type=\"email\">                        
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
                <img class='rounded-circle w-25' src=\"$foto_avatar\" alt=\"\">
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
                <img class='rounded w-50' src=\"$foto\" alt=\"\">
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
                getGroupAlbums($_SESSION["user"]);
            echo "</section>
                </section>";
        $consulta->close();
        $con->close();
    }

    function updateAvatarPhoto($mail, $foto_avatar){
        $con = createConnection();
        $update = $con->prepare("UPDATE grupo set foto_avatar = ? where correo = ?");
        $update->bind_param('ss', $foto_avatar, $mail);
        $update->execute();
        $update->close();
        $con->close();
    }

    function updateMainPhoto($mail, $foto){
        $con = createConnection();
        $update = $con->prepare("UPDATE grupo set foto = ? where correo = ?");
        $update->bind_param('ss', $foto, $mail);
        $update->execute();
        $update->close();
        $con->close();
    }

    // function getGroupInfo2($mail){
    //     $con = createConnection();
    //     $consulta = $con->prepare("SELECT nombre, foto, foto_avatar, biografia from grupo where correo = ?");
    //     $consulta->bind_param('s', $mail);
    //     $consulta->bind_result($nombre, $foto, $foto_avatar, $bio);
    //     $consulta->execute();
    //     $consulta->fetch();
    //     echo "<section class='banner-group-main' data-bg='$foto'><img class='img-fluid' src='$foto'><img src='$foto_avatar'></section>";
    //     $consulta->close();
    //     $con->close();
    // }

    function getStyles(){
        $con = createConnection();
        $consulta = $con->prepare("SELECT nombre, id FROM estilo where id <> 0");
        $consulta->bind_result($nombre, $id);
        $consulta->execute();
        while($consulta->fetch()) {
            echo "<option class=\"p-2\" value=\"$id\">$nombre</option>";
        }
        $consulta->close();
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
                        <li><a class=\"dropdown-item\" href=\"grupo_nuevo_album.php\">Subir nuevo álbum</a></li>
                        <li><a class=\"dropdown-item\" href=\"grupo_anadir_publicacion.php\">Añadir publicación</a></li>
                        <li><a class=\"dropdown-item\" href=\"grupo_mis_resenas.php\">Reseñas de mis álbumes</a></li>
                        <li><a class=\"dropdown-item\" href=\"grupo_miembros.php\">Miembros de grupo</a></li>
                        <li><form action=\"#\" method=\"post\"><input class='dropdown-item' id=\"cerrar-user\" type=\"submit\" name=\"cerrar-sesion\" value=\"Cerrar sesión\"></form></li>
                    </ul>
                </div>
              </header>";
    }

    function completeInformation($mail, $bio, $foto, $foto_avatar){
        $con = createConnection();
        $actualizacion = $con->prepare("UPDATE grupo SET biografia = ?, foto = ?, foto_avatar = ? WHERE correo = ?");
        $actualizacion->bind_param("ssss", $bio, $foto, $foto_avatar, $mail);
        $actualizacion->execute();
        $actualizacion->close();
        $con->close();
    }

    function checkPhoto($nombre){
        $correcto = false;
        $formato = $_FILES[$nombre]["type"];
        $size = $_FILES[$nombre]["size"];
        $size_mb = $size / pow(1024, 2);

        if($size_mb < 10 and ($formato == "image/jpeg" or $formato == "image/png" or $formato == "image/gif" or $formato == "image/webp")){
            $correcto = true;
        }
        return $correcto;
    }

    function newPhotoPath($nombre, $tipo){
        $nuevo_nombre;
        switch($_FILES[$nombre]["type"]){
            case "image/jpeg":
                $nuevo_nombre = $_SESSION["user"].$tipo.".jpg";
                break;
            case "image/png":
                $nuevo_nombre = $_SESSION["user"].$tipo.".png";
                break;
            case "image/gif":
                $nuevo_nombre = $_SESSION["user"].$tipo.".gif";
                break;
            case "image/webp":
                $nuevo_nombre = $_SESSION["user"].$tipo.".webp";
                break;
        }
        if(!file_exists("../media/img_grupos/".$_SESSION["user"])){
            mkdir("../media/img_grupos/".$_SESSION["user"], 0777, true);
        }
        $nueva_ruta = "../media/img_grupos/".$_SESSION["user"]."/".$nuevo_nombre;
        move_uploaded_file($_FILES[$nombre]["tmp_name"], $nueva_ruta);
        return $nueva_ruta;
    }
    
    function removeSpecialCharacters($nombre){
        $quitar = ["/", "*","'","[","]", "?", "(", ")"];
        $arreglado = strtolower(str_replace($quitar, "", $nombre));
        return $arreglado;
    }
    function newPhotoPathAlbum($nombre, $album){
        $nuevo_nombre;
        $quitar = ["/", ".", "*","'",":", "?", "(", ")"];
        $album = strtolower(str_replace($quitar, "", $album));

        switch($_FILES[$nombre]["type"]){
            case "image/jpg":
                $nuevo_nombre = $album.".jpg";
                break;
            case "image/jpeg":
                $nuevo_nombre = $album.".jpg";
                break;
            case "image/png":
                $nuevo_nombre = $album.".png";
                break;
            case "image/gif":
                $nuevo_nombre = $album.".gif";
                break;
            case "image/webp":
                $nuevo_nombre = $album.".webp";
                break;
        }
        if(!file_exists("../media/img_grupos/".$_SESSION["user"])){
            mkdir("../media/img_grupos/".$_SESSION["user"], 0777, true);
        }

        $nueva_ruta = "../media/img_grupos/".$_SESSION["user"]."/".$nuevo_nombre;
        move_uploaded_file($_FILES[$nombre]["tmp_name"], $nueva_ruta);
        return $nueva_ruta;
    }

    function addAlbum($grupo, $nombre, $foto, $lanzamiento, $activo){
        $con = createConnection();
        $insercion = $con->prepare("INSERT INTO album (titulo,foto,activo,grupo,lanzamiento) values (?, ?, ?, ?, ?)");
        $insercion->bind_param('ssiis', $nombre, $foto, $activo, $grupo, $lanzamiento);
        $insercion->execute();
        $insercion->close();
        $con->close();
    }

    function getGroupID($mail){
        $con = createConnection();
        $consulta = $con->prepare("SELECT id from grupo where correo = ?");
        $consulta->bind_param('s', $mail);
        $consulta->bind_result($id);
        $consulta->execute();
        $consulta->fetch();
        $consulta->close();
        $con->close();
        return $id;
    }
    
    function getAllGroupSongs($id){
        $con = createConnection();
        $consulta = $con->prepare("SELECT distinct c.id cancion_id, c.titulo titulo_cancion from grupo g, album a, cancion c, incluye i where a.grupo = g.id and i.cancion = c.id and i.album = a.id and g.id = ?");
        $consulta->bind_param('i', $id);
        $consulta->bind_result($id, $cancion);
        $consulta->execute();
        while($consulta->fetch()){
            echo "<option value=\"$id\">$cancion</option>";
        }
        $consulta->close();
        $con->close();
    }

    function generateInputs($num){
        $contador = 1;
        echo "<ul class='song-adder-list d-flex flex-column gap-5'>";
        while($contador <= $num){
            $name = "titulo".$contador;
            $name2 = "archivo".$contador;
            $name3 = "estilo".$contador;
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
            $contador++;
        }
        echo "</ul>
                <button name='cargar' style='--clr:#c49c23' class='btn-danger-own'><span>Cargar álbum</span><i></i></button>";
    }

    function generateSelects($num, $id){
        $contador = 1;
        echo "<ul class='selects-container'>";
        while($contador <= $num){
            $name = "cancion".$contador;
            echo "<li><select required name=\"$name\"><option value='' hidden>Elige una canción</option>";
                getAllGroupSongs($id);
                 echo "</select></li>";
            $contador++;
        }
        echo "</ul><button name='cargar' style='--clr:#c49c23' class='btn-danger-own'><span>Cargar álbum</span><i></i></button>";
    }

    function getDuration($cancion){
        $mp3file = new MP3File($cancion);
        $duration_seconds = $mp3file->getDurationEstimate();
        $minutos = MP3File::formatTime($duration_seconds);
        return $minutos;
    }

    function addSong($titulo, $archivo, $duracion, $estilo){
        $con = createConnection();
        $insertar = $con->prepare("INSERT INTO cancion (titulo,duracion,archivo,estilo) values (?,?,?,?)");
        $insertar->bind_param('sssi', $titulo, $duracion, $archivo, $estilo);
        $insertar->execute();
        $filas_afectadas = $insertar->affected_rows;
        $insertar->close();
        $con->close();
        return $filas_afectadas;
    }

    function linkSongToAlbum($album, $cancion){
        $con = createConnection();
        $insertar = $con->prepare("INSERT INTO incluye (album,cancion) values (?,?)");
        $insertar->bind_param('ii', $album, $cancion);
        $insertar->execute();
        $filas_afectadas = $insertar->affected_rows;
        $insertar->close();
        $con->close();
        return $filas_afectadas;
    }

    function moveUploadedSong($nombre, $grupo, $album){
        $album = removeSpecialCharacters($album);
        if(!file_exists("../media/audio/$grupo")){
            mkdir("../media/audio/$grupo");
        }
        // echo $album;
        // echo $_SERVER['DOCUMENT_ROOT']."/SonicWaves/media/audio/$grupo/$album";
        if(!file_exists("../media/audio/$grupo/$album")){
            if(!mkdir("../media/audio/$grupo/$album")){
                echo "Error, no se pudo crear la carpeta $grupo $album";
            }
        }
        $cancion = $_FILES[$nombre]["name"];
        $cancion = removeSpecialCharacters($cancion);
        $nueva_ruta = "../media/audio/$grupo/$album/$cancion";
        move_uploaded_file($_FILES[$nombre]["tmp_name"], $nueva_ruta);
        return $nueva_ruta;
    }

    function getLastSongID(){
        $con = createConnection();
        $consulta = $con->query("SELECT id from cancion order by id desc limit 1");
        $fila = $consulta->fetch_array(MYSQLI_ASSOC);
        $id = $fila["id"];
        return $id;
    }

    function getGroupName($id){
        $con = createConnection();
        $consulta = $con->prepare("SELECT nombre from grupo where id = ?");
        $consulta->bind_param('i', $id);
        $consulta->bind_result($nombre);
        $consulta->execute();
        $consulta->fetch();
        $consulta->close();
        $con->close();
        return $nombre;
    }

    function updateBio($mail, $bio){
        $con = createConnection();
        $update = $con->prepare("UPDATE grupo set biografia = ? where correo = ?");
        $update->bind_param('ss', $bio, $mail);
        $update->execute();
        $update->close();
        $con->close();
    }

    function emailRepeatedAtUpdate($mail, $mail_act){
        $con = createConnection();
        $consulta = $con->prepare("SELECT count(*) from grupo where correo = ? or correo = ?");
        $consulta->bind_param('ss', $mail, $mail_act);
        $consulta->bind_result($count);
        $consulta->execute();
        $consulta->fetch();
        $consulta->close();
        $con->close();
        return $count;
    }

    function updateGroupData($user, $mail, $pass){
        $con = createConnection();
        $update = $con->prepare("UPDATE grupo set correo = ?, pass = ? where correo = ?");
        $update->bind_param('sss', $mail, $pass, $user);
        $update->execute();
        $update->close();
        $con->close();
    }

    function addPost($mail, $titulo, $contenido, $foto, $fecha){
        $con = createConnection();
        $id = getGroupID($mail);
        $insert = $con->prepare("INSERT into publicacion (titulo, contenido, foto, fecha, grupo) values (?,?,?,?,?)");
        $insert->bind_param('ssssi', $titulo, $contenido, $foto, $fecha, $id);
        $insert->execute();
        $insert->close();
        $con->close();
    }

    function checkPhotosArray($nombre, $index){
        $correcto = false;
        $formato = $_FILES[$nombre]["type"][$index];
        $size = $_FILES[$nombre]["size"][$index];
        $size_mb = $size / pow(1024, 2);

        if($size_mb < 10 and ($formato == "image/jpeg" or $formato == "image/png" or $formato == "image/gif" or $formato == "image/webp")){
            $correcto = true;
        }
        return $correcto;
    }

    function newPhotoPathPost($tipo, $num_foto, $id_post, $ruta_serv){
        $nuevo_nombre;
        // $quitar = ["/", ".", "*","'"];
        // $album = strtolower(str_replace($quitar, "", $album));

        switch($tipo){
            case "image/jpeg":
                $nuevo_nombre = "foto".$num_foto."post".$id_post.".jpg";
                break;
            case "image/png":
                $nuevo_nombre = "foto".$num_foto."post".$id_post.".png";
                break;
            case "image/gif":
                $nuevo_nombre = "foto".$num_foto."post".$id_post.".gif";
                break;
            case "image/webp":
                $nuevo_nombre = "foto".$num_foto."post".$id_post.".webp";
                break;
        }
        if(!file_exists("../media/img_posts/".$_SESSION["user"])){
            mkdir("../media/img_posts/".$_SESSION["user"], 0777, true);
        }
        $nueva_ruta = "../media/img_posts/".$_SESSION["user"]."/".$nuevo_nombre;
        move_uploaded_file($ruta_serv, $nueva_ruta);
        return $nueva_ruta;
    }

    function newMainPhotoPathPost($id_post){
        $nuevo_nombre;
        // $quitar = ["/", ".", "*","'"];
        // $album = strtolower(str_replace($quitar, "", $album));

        switch($_FILES["foto"]["type"]){
            case "image/jpeg":
                $nuevo_nombre = "fotoPrincipalpost".$id_post.".jpg";
                break;
            case "image/png":
                $nuevo_nombre = "fotoPrincipalpost".$id_post.".png";
                break;
            case "image/gif":
                $nuevo_nombre = "fotoPrincipalpost".$id_post.".gif";
                break;
            case "image/webp":
                $nuevo_nombre = "fotoPrincipalpost".$id_post.".webp";
                break;
        }
        if(!file_exists("../media/img_posts/".$_SESSION["user"])){
            mkdir("../media/img_posts/".$_SESSION["user"], 0777, true);
        }
        $nueva_ruta = "../media/img_posts/".$_SESSION["user"]."/".$nuevo_nombre;
        move_uploaded_file($_FILES["foto"]["tmp_name"], $nueva_ruta);
        return $nueva_ruta;
    }

    function addPostPhotos($enlace, $publicacion){
        $con = createConnection();
        $insert = $con->prepare("INSERT INTO foto_publicacion (enlace, publicacion) values (?, ?)");
        $insert->bind_param('si', $enlace, $publicacion);
        $insert->execute();
    }

    function newGroupPhotoPath($num, $tipo, $tmp){
        $nuevo_nombre;
        switch($tipo){
            case "image/jpeg":
                $nuevo_nombre = $_SESSION["user"]."fotoextra".$num.".jpg";
                break;
            case "image/png":
                $nuevo_nombre = $_SESSION["user"]."fotoextra".$num.".png";
                break;
            case "image/gif":
                $nuevo_nombre = $_SESSION["user"]."fotoextra".$num.".gif";
                break;
            case "image/webp":
                $nuevo_nombre = $_SESSION["user"]."fotoextra".$num.".webp";
                break;
        }
        if(!file_exists("../media/img_grupos/".$_SESSION["user"])){
            mkdir("../media/img_grupos/".$_SESSION["user"], 0777, true);
        }
        $nueva_ruta = "../media/img_grupos/".$_SESSION["user"]."/".$nuevo_nombre;
        move_uploaded_file($tmp, $nueva_ruta);
        return $nueva_ruta;
    }

    function addGroupExtraPhoto($foto, $id_grupo){
        $con = createConnection();
        $insert = $con->prepare("INSERT INTO foto_grupo (enlace, grupo) values (?,?)");
        $insert->bind_param('si', $foto, $id_grupo);
        $insert->execute();
        $insert->close();
        $con->close();
    }

    function checkPhotoLimit($user){
        $con = createConnection();
        $id = getGroupID($user);
        $consulta = $con->prepare("SELECT count(*) from foto_grupo where grupo = ?");
        $consulta->bind_param('i', $id);
        $consulta->bind_result($count);
        $consulta->execute();
        $consulta->fetch();
        $consulta->close();
        $con->close();
        return $count;
    }

    function getGroupExtraPhotos($user){
        $con = createConnection();
        $id = getGroupID($user);
        $consulta = $con->prepare("SELECT id, enlace from foto_grupo where grupo = ?");
        $consulta->bind_param('i', $id);
        $consulta->bind_result($id, $enlace);
        $consulta->execute();
        $consulta->store_result();
        if($consulta->num_rows > 0){
            while($consulta->fetch()){
                echo "<form action='#' method='post' class='position-relative'>
                        <img src='$enlace' class='img-fluid object-fit-cover'>
                        <input hidden value='$id' name='id-foto'>
                        <button style='--clr:#e80c0c' class='btn-danger-own position-absolute' name='eliminar-foto'><span>Eliminar</span><i></i></button>
                     </form>";
            }
        }else{
            echo "<div class=\"alert no-f alert-warning mt-3\" role=\"alert\">Sin fotos extra</div>";
        }
        $consulta->close();
        $con->close();
    }

    function getPhotoLink($id){
        $con = createConnection();
        $consulta = $con->prepare("SELECT enlace from foto_grupo where id = ?");
        $consulta->bind_param('i', $id);
        $consulta->bind_result($enlace);
        $consulta->execute();
        $consulta->fetch();
        $consulta->close();
        $con->close();
        return $enlace;
    }

    function deletePhoto($id){
        $enlace = getPhotoLink($id);
        $con = createConnection();
        $delete = $con->prepare("DELETE FROM foto_grupo where id = ?");
        $delete->bind_param('i', $id);
        $delete->execute();
        $delete->close();
        $con->close();
        unlink($enlace);
    }

    function checkEnoughAlbumsGroup($id_grupo){
        $con = createConnection();
        $consulta = $con->query("SELECT count(*) total from album a, grupo g where a.grupo = g.id and g.id = $id_grupo");
        $fila = $consulta->fetch_array(MYSQLI_ASSOC);
        $total = $fila["total"];
        $con->close();
        return $total;
    }

    function getAlbumsWithReviews($mail){
        $con = createConnection();
        $consulta = $con->prepare("SELECT a.foto foto, titulo, a.id id from album a, grupo g where a.grupo = g.id and g.correo = ?");
        $consulta->bind_param('s', $mail);
        $consulta->bind_result($foto, $titulo, $id);
        $consulta->execute();
        while($consulta->fetch()){
            $total_reviews = totalAlbumReviews($id);
            echo "<div class='d-flex gap-3 align-items-center rounded album-review-group-container'>
                    <div class='album-review-container-img'>
                        <img src='$foto' class='img-fluid'>
                        <canvas></canvas>
                    </div>
                    <div class='d-flex flex-column gap-1'>
                        <h4 class='mt-0'>$titulo</h4>
                        <h4>Reseñas totales: $total_reviews</h4>
                    ";
            if($total_reviews != 0){
                echo "<form action='grupo_resenas_album.php' method='get'>
                        <input hidden name='id' value='$id'>
                        <button style='--clr:#e80c0c' class='btn-danger-own' name='ver-reseñas'><span>Ver reseñas</span><i></i></button></div></div>
                    </form>";
            }else{
                echo "</div></div>";
            }
                
        }
        $consulta->close();
        $con->close();
    }

    function getAllReviewsOfAlbum($id){
        $con = createConnection();
        $consulta = $con->prepare("SELECT titulo, contenido, fecha, foto_avatar from reseña r, usuario u where r.usuario = u.id and album = ?");
        $consulta->bind_param('i', $id);
        $consulta->bind_result($titulo, $contenido, $fecha, $foto);
        $consulta->execute();
        $consulta->store_result();

        if($consulta->num_rows > 0){
            while($consulta->fetch()){
                $fecha = formatDate($fecha);
                echo "<div class='d-flex flex-column gap-3 review-individual-container-group-section'>
                        <div class='d-flex align-items-center gap-2'>
                            <img src='$foto' class='rounded-circle'>
                            <h2 class='m-0'>$titulo</h2>
                        </div>
                        <p>$contenido</p>
                        <i>Reseña escrita el $fecha</i>
                    </div>";
            }
        }else{
            echo "<h3>No hay reseñas escritas aún</h3>";
        }
        
        $consulta->close();
        $con->close();
    }

    function groupHasMembers($mail){
        $id = getGroupID($mail);
        $con = createConnection();
        $consulta = $con->prepare("SELECT count(*) from usuario where grupo = ?");
        $consulta->bind_param('i', $id);
        $consulta->bind_result($miembros);
        $consulta->execute();
        $consulta->fetch();
        $consulta->close();
        $con->close();
        return $miembros;
    }

    function userExists($usuario){
        $con = createConnection();
        $consulta = $con->prepare("SELECT count(*) from usuario where usuario = ?");
        $consulta->bind_param('s', $usuario);
        $consulta->bind_result($existe);
        $consulta->execute();
        $consulta->fetch();
        $consulta->close();
        $con->close();
        return $existe;
    }

    function userIsMember($usuario){
        $con = createConnection();
        $consulta = $con->prepare("SELECT grupo from usuario where usuario = ?");
        $consulta->bind_param('s', $usuario);
        $consulta->bind_result($es_miembro);
        $consulta->execute();
        $consulta->fetch();
        $consulta->close();
        $con->close();
        return $es_miembro;
    }
    
    function addNewMember($usuario, $mail){
        $id_grupo = getGroupID($mail);
        $con = createConnection();
        $insert = $con->prepare("UPDATE usuario set grupo = ? where usuario = ?");
        $insert->bind_param('is', $id_grupo, $usuario);
        $insert->execute();
        $insert->close();
        $con->close();
    }
    
    function removeMember($usuario){
        $eliminado = false;
        $con = createConnection();
        $update = $con->prepare("UPDATE usuario set grupo = 0 where id = ?");
        $update->bind_param('i', $usuario);
        $update->execute();
        if($update){
            $eliminado = true;
        }
        $update->close();
        $con->close();
        return $eliminado;
    }
    
    function getGroupMembers($mail){
        $id = getGroupID($mail);
        $con = createConnection();
        $consulta = $con->prepare("SELECT usuario, foto_avatar, id from usuario where grupo = ?");
        $consulta->bind_param('i', $id);
        $consulta->bind_result($usuario, $foto, $id_usuario);
        $consulta->execute();
        while($consulta->fetch()){
            echo "<div class='d-flex align-items-center gap-3'>
                    <img src='$foto' class='group-member-avatar img-fluid rounded-circle'>
                    <h3 class='m-0'>$usuario</h3>
                    <form action='#' method='post'>
                        <input hidden value='$id_usuario' name='usuario'>
                        <button style='--clr:#dc143c' class='btn-danger-own' name='eliminar-miembro'><span>Eliminar</span><i></i></button>
                    </form>
                  </div>";
        }
        $consulta->close();
        $con->close();
    }
?>
