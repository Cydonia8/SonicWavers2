<?php
    function menuPatronDropdown(){
        echo "<header class=\"dropdown-header d-flex justify-content-between align-items-center pt-3 pe-3 pb-2 ps-3 border-bottom\">
                <a class=\"dropdown-link-responsive\" href=\"../index.php\"><img src=\"../media/assets/sonic-waves-logo-simple.png\"></a>
                <a href=\"../index.php\"><img class=\"w-25\" src=\"../media/assets/sonic-waves-high-resolution-logo-color-on-transparent-background (1).png\"></a>
                <div class=\"dropdown-admin-disc-group\">
                    <button class=\"btn btn-secondary btn-lg dropdown-toggle\" type=\"button\" data-bs-toggle=\"dropdown\" aria-expanded=\"false\">
                    Menú de mecenas
                    </button>
                    <ul class=\"dropdown-menu\">
                        <li><a class=\"dropdown-item\" href=\"patrons_main.php\">Resumen de mecenas</a></li>
                        <li><a class=\"dropdown-item\" href=\"discografica_grupos.php\">Enviar mensaje a grupo</a></li>
                        <li><a class=\"dropdown-item\" href=\"discografica_anadir_grupo.php\">Mis mensajes</a></li>
                        <li><form action=\"#\" method=\"post\"><input id=\"cerrar-user\" type=\"submit\" name=\"cerrar-sesion\" value=\"Cerrar sesión\"></form></li>
                    </ul>
                </div>
              </header>";
    }

    function getPatronInformation($mail){
        $con = createConnection();
        $query = $con->prepare("SELECT name, mail, pass, foto_avatar from patrons where mail = ?");
        $query->bind_param('s', $mail);
        $query->bind_result($name, $mail, $pass, $foto);
        $query->execute();
        $query->fetch();
        echo "<div class='d-flex flex-column flex-md-row justify-content-evenly gap-5 align-items-center'>
                <a class='avatar-discografica-editable position-relative w-25' href=''>
                    <img src='$foto' class='rounded-circle img-fluid avatar-discografica-editable'>
                    <ion-icon class='icon-edit-avatar-discografica d-none' name=\"pencil-outline\"></ion-icon>
                </a>
                <form class='d-flex flex-column gap-3 form-editar-datos-discografica' action='#' method='post'>
                    <legend class='text-center'>Datos</legend>
                    <div class=\"input-field d-flex flex-column gap-3 mb-3\">
                        <div class=\"input-visuals d-flex justify-content-between\">
                            <label for=\"usuario\">Nombre (no editable)</label>
                            <ion-icon name=\"person-outline\"></ion-icon>
                        </div>
                        <input readonly disabled value='$name' name=\"nombre\" type=\"text\">                        
                    </div>
                    <div class=\"input-field d-flex flex-column gap-3 mb-3\">
                        <div class=\"input-visuals d-flex justify-content-between\">
                            <label for=\"usuario\">Correo (para modificarlo contacte con los administradores)</label>
                            <ion-icon name=\"person-outline\"></ion-icon>
                        </div>
                        <input readonly disabled value='$mail' name=\"mail\" type=\"email\">                        
                    </div>
                    <div class=\"input-field d-flex flex-column gap-3 mb-3\">
                        <div class=\"input-visuals d-flex justify-content-between\">
                            <label for=\"usuario\">Contraseña</label>
                            <ion-icon name=\"person-outline\"></ion-icon>
                        </div>
                        <input name=\"pass\" type=\"password\">
                        <input class='pass-original' hidden value='$pass' name='pass-original'>                        
                    </div>
                    <button style='--clr:#0A90DD' class='btn-danger-own' name='modificar-datos'><span>Modificar</span><i></i></button>
                </form>
              </div>
              <section class=\"update-avatar-photo d-none flex-column justify-content-center align-items-center\">
                    <ion-icon class='close-modal-update-avatar position-absolute' name=\"close-outline\"></ion-icon>
                    <img class='rounded-circle w-25' src=\"$foto\" alt=\"\">
                    <form class='text-center' action=\"#\" method=\"post\" enctype=\"multipart/form-data\">
                        <div class=\"input-field  mb-3 gap-2\">
                            <div class=\" justify-content-between\">
                                <label class=\"file\">Foto de avatar</label>
                                <ion-icon name=\"image-outline\"></ion-icon>
                                <input type=\"file\" class=\"custom-file-input\" name=\"foto-avatar-nueva\">
                            </div>
                        </div>
                        <button style='--clr:#0A90DD' class='btn-danger-own' name='actualizar-avatar'><span>Actualizar foto de avatar</span><i></i></button>
                    </form>
                </section>";
        $query->close();
        $con->close();
    }

    function newPhotoPathAvatarPatron($nombre, $tipo, $discografica){
        $nuevo_nombre;
        switch($_FILES[$nombre]["type"]){
            case "image/jpeg":
                $nuevo_nombre = $discografica.'_'.$tipo.'.jpg';
                break;
            case "image/png":
                $nuevo_nombre = $discografica.'_'.$tipo.'.png';
                break;
            case "image/gif":
                $nuevo_nombre = $discografica.'_'.$tipo.'.gif';
                break;
            case "image/webp":
                $nuevo_nombre = $discografica.'_'.$tipo.'.webp';
                break;
        }
        if(!file_exists("../media/image_patrons/".$discografica)){
            mkdir("../media/image_patrons/".$discografica, 0777, true);
        }
        $nueva_ruta = "../media/image_patrons/".$discografica.'/'.$nuevo_nombre;
        move_uploaded_file($_FILES[$nombre]["tmp_name"], $nueva_ruta);
        return $nueva_ruta;
    }

    function updatePatronAvatarPhoto($mail, $foto_avatar){
        $con = createConnection();
        $update = $con->prepare("UPDATE patrons set foto_avatar = ? where mail = ?");
        $update->bind_param('ss', $foto_avatar, $mail);
        $update->execute();
        $update->close();
        $con->close();
    }

    function updatePatronData($user, $pass){
        $con = createConnection();
        $update = $con->prepare("UPDATE patrons set pass = ? where mail = ?");
        $update->bind_param('ss', $pass, $user);
        $update->execute();
        $update->close();
        $con->close();
    }
?>