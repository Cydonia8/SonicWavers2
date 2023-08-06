<?php
    session_start();
    require_once "../square_image_creator/create_square_image.php";
    require_once "../php_functions/general.php";
    require_once "../php_functions/discografica_functions.php";
    require_once "../php_functions/group_functions.php";
    forbidAccess("disc");
    closeSession($_POST);

    if(isset($_POST["editar-group"])){
        $_SESSION["id"] = $_POST["id"];
    }
    
    $datos = getGroupDataEdit($_SESSION["id"]);
    if(isset($_POST["editar"])){
        $nombre = $_POST["nombre"];
        $bio = $_POST["bio"];
        $foto = $_FILES["foto-nueva"]["name"] != '' ? checkPhoto("foto-nueva") : $_POST["foto-original"];
        $foto_correcta = true;
        $foto_avatar_correcta= true;
        if(is_bool($foto)){
            if($foto){
                $foto = newPhotoPathDisc("foto-nueva", "", $nombre, $_SESSION["id"]);
                $foto_correcta = true;
            }else{
                $foto_correcta = false;
            }
        }
        $foto_avatar = $_FILES["foto-avatar-nueva"]["name"] != '' ? checkPhoto("foto-avatar-nueva") : $_POST["foto-avatar-original"];   
        
        if(is_bool($foto_avatar)){
            if($foto_avatar){
                $foto_avatar = newPhotoPathDisc("foto-avatar-nueva", "avatar",  $nombre, $_SESSION["id"]);
                $foto_avatar_correcta = true;               
            }else{
                $foto_avatar_correcta = false;
            }
        }
        if($foto_correcta and $foto_avatar_correcta){
            editGroup($_SESSION["id"], $bio, $foto, $foto_avatar);
        }
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../estilos.css">
    <script src="../scripts/editar_grupo.js" defer></script>
    <script src="../scripts/jquery-3.2.1.min.js" defer></script>
    <link rel="icon" type="image/png" href="../media/assets/favicon-32x32-modified.png" sizes="32x32" />
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js" defer></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js" defer></script>
    <title>Editar datos</title>
</head>
<body id="discografica-editar-grupo">
    <?php
        menuDiscograficaDropdown();
        $nombre = getDiscographicName($_SESSION["user"])
    ?>
    <h1 class="text-center mt-3"><?php echo $datos["nombre"]; ?></h1>
    <section class="row container-fluid mt-5 mx-auto">
        <div class="col-12 col-lg-6">
            <form action="#" method="post" enctype="multipart/form-data" class="d-flex flex-column">
                <h2 class="text-center">Formulario de edición de grupo</h2>
                <div class="input-field d-flex flex-column mb-3">
                    <div class="input-visuals d-flex justify-content-between">
                        <label for="usuario">Nombre del grupo (este valor no puede ser modificado)</label>
                        <ion-icon name="person-outline"></ion-icon>
                    </div>
                    <input readonly <?php echo "value='$datos[nombre]'"; ?> name="nombre" type="text">                        
                </div>
                <div class="input-field d-flex flex-column mb-3">
                    <div class="input-visuals d-flex justify-content-between">
                        <label for="usuario">Biografía</label>
                        <ion-icon name="person-outline"></ion-icon>
                    </div>
                    <textarea name="bio" id="" cols="30" rows="10" maxlength="5000" required><?php echo $datos["bio"]; ?></textarea>                        
                </div>
                <div class="input-field d-flex flex-column mb-3 gap-2">
                    <div class="d-flex justify-content-between"><label class="file">Foto principal del grupo</label><ion-icon name="image-outline"></ion-icon></div>
                        <input type="file" class="custom-file-input" name="foto-nueva">
                        <input hidden name="foto-original" <?php echo "value='$datos[foto]'"; ?>>                  
                </div>
                    <div class="input-field d-flex flex-column mb-3 gap-2">
                    <div class="d-flex justify-content-between"><label class="file">Foto de avatar del grupo</label><ion-icon name="image-outline"></ion-icon></div>
                        <input type="file" class="custom-file-input" name="foto-avatar-nueva">
                        <input hidden name="foto-avatar-original" <?php echo "value='$datos[foto_avatar]'"; ?>>
                    
                </div>
                <!-- <input type="submit" name="editar" value="Editar" class="mb-3"> -->
                <button style='--clr:#0A90DD' class='btn-danger-own mb-3' name='editar'><span>Editar</span><i></i></button>
            </form>
        </div>
        <div class="col-12 col-lg-6">
            <img class="img-fluid rounded" <?php echo "src='$datos[foto]'"; ?> alt="">
        </div>
    

    </section>
    <?php
        if(isset($foto) and is_bool($foto) and !$foto){
            echo "<div class=\"alert alert-danger text-center mt-4\" role=\"alert\">Archivo de foto incorrecto</div>";
        }
        if(isset($foto_avatar) and is_bool($foto_avatar) and !$foto_avatar){
            echo "<div class=\"alert alert-danger text-center mt-4\" role=\"alert\">Archivo de foto de avatar incorrecto</div>";
        }

    ?>
</body>
</html>
