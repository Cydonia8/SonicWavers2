<?php
    session_start();
    require_once "../php_functions/discografica_functions.php";
    require_once "../php_functions/group_functions.php";
    require_once "../php_functions/general.php";
    forbidAccess("disc");
    closeSession($_POST);
    $id_discografica = getDiscographicID($_SESSION["user"]);
    $nombre = getDiscographicName($_SESSION["user"]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../estilos.css">
    <script src="../scripts/jquery-3.2.1.min.js" defer></script>
    <link rel="icon" type="image/png" href="../media/assets/favicon-32x32-modified.png" sizes="32x32" />
    <title><?php echo $nombre; ?> | Añadir grupo</title>
</head>
<body id="discografica-nuevo-grupo">
    <?php
        menuDiscograficaDropdown();
    ?>
    <section class="container-xl mt-3">
        <h1 class='text-center mb-4'>Nuevo grupo</h1>
        <form class="d-flex flex-column gap-3 w-50 mx-auto" action="#" method="post" enctype="multipart/form-data">
            <div class="input-field d-flex flex-column mb-3">
                <div class="input-visuals d-flex justify-content-between">
                    <label for="usuario">Nombre del grupo</label>
                    <ion-icon name="radio-outline"></ion-icon>
                </div>
                <input type="text" placeholder="Nombre..." name="nombre" required>                      
            </div>
            <div class="input-field d-flex flex-column mb-3">
                <div class="input-visuals d-flex justify-content-between">
                    <label for="usuario">Foto de grupo</label>
                    <ion-icon name="radio-outline"></ion-icon>
                </div>
                <input type="file" name="foto" required>                      
            </div>
            <div class="input-field d-flex flex-column mb-3">
                <div class="input-visuals d-flex justify-content-between">
                    <label for="usuario">Foto de avatar</label>
                    <ion-icon name="radio-outline"></ion-icon>
                </div>
                <input type="file" name="foto-avatar" required>                      
            </div>
            <div class="input-field d-flex flex-column mb-3">
                <div class="input-visuals d-flex justify-content-between">
                    <label for="usuario">Título del álbum</label>
                    <ion-icon name="radio-outline"></ion-icon>
                </div>
                <textarea name="biografia" placeholder="Escribe una biografia" id="" cols="30" rows="10" maxlength="2000" required></textarea>                     
            </div>
            <button style='--clr:#0A90DD' class='btn-danger-own' name='anadir'><span>Añadir grupo</span><i></i></button>
        </form>
    </section>
        <?php
            if(isset($_POST['anadir'])){
                $nombre = $_POST['nombre'];
                $bio = $_POST['biografia'];
                $foto_correcta = checkPhoto("foto");
                $foto_avatar_correcta = checkPhoto("foto-avatar");
                $id_grupo = getAutoID("grupo");
                if($foto_correcta and $foto_avatar_correcta){
                    $foto_avatar = newPhotoPathDisc("foto-avatar", "avatar",  $nombre, $id_grupo);
                    $foto = newPhotoPathDisc("foto", "", $nombre, $id_grupo);
                    addGroup($nombre, $bio, $foto, $foto_avatar, 0, $id_discografica);
                    echo "<div class=\"alert alert-success text-center mx-auto w-50 mt-5\" role=\"alert\">
                            Nuevo grupo insertado correctamente y a la espera de ser aprobado
                        </div>";
                }
            }
        ?>
</body>
</html>
