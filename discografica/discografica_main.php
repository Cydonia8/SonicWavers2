<?php
    session_start();
    require_once "../square_image_creator/create_square_image.php";
    require_once "../php_functions/general.php";
    require_once "../php_functions/discografica_functions.php";
    require_once "../php_functions/group_functions.php";
    forbidAccess("disc");
    closeSession($_POST);
    $nombre = getDiscographicName($_SESSION["user"]);

    if(isset($_POST["actualizar-avatar"])){
        $foto_avatar_correcta = checkPhoto("foto-avatar-nueva");
        if($foto_avatar_correcta){
            $foto_avatar = newPhotoPathAvatarDiscographic("foto-avatar-nueva", "avatar", $_SESSION["user"]);
            updateDiscographicAvatarPhoto($_SESSION["user"], $foto_avatar);
            $foto_actualizada = true;
        }else{
            $foto_actualizada = false;
        }
    }
    if(isset($_POST["modificar-datos"])){
        $mail = $_POST["mail"] != '' ? $_POST["mail"] : $_SESSION["user"];
        $pass = $_POST["pass"] != '' ? $_POST["pass"] : $_POST["pass-original"];
        $mail_repetido = discographicEmailRepeatedAtUpdate($mail, $_SESSION["user"]);
        if($mail_repetido == 0){
            updateDiscographicData($_SESSION["user"], $mail, $pass);
            $_SESSION["user"] = $mail;
            // echo $mail;
            // echo $pass;
            // echo $_SESSION["user"];
        }
    }
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
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <link rel="stylesheet" href="../estilos.css">
    <script src="../scripts/discografica_main.js" defer></script>
    <script src="../scripts/jquery-3.2.1.min.js"></script>
    <link rel="icon" type="image/png" href="../media/assets/favicon-32x32-modified.png" sizes="32x32" />
    <title><?php echo $nombre;?> | Perfil</title>
</head>
<body id="discografica-main">
    <?php
        menuDiscograficaDropdown();
    ?>
    <h1 class="mt-3 text-center"><?php echo $nombre;?></h1>
    <section>
        <?php
            getDiscographicInformation($_SESSION["user"]);
        ?>
    </section>
    <?php
        if(isset($mail_repetido) and $mail_repetido == 1){
            echo "<div class=\"alert alert-danger text-center mx-auto w-50 mt-5\" role=\"alert\">
            Correo ya registrado en Sonic Waves
          </div>";
        }elseif(isset($mail_repetido) and $mail_repetido == 0){
            echo "<div class=\"alert alert-success text-center mx-auto w-50 mt-5\" role=\"alert\">
            Datos modificados correctamente
          </div>";
        }

        if(isset($foto_actualizada)){
            if($foto_actualizada){
                echo "<div class=\"alert alert-success text-center mx-auto w-50 mt-5\" role=\"alert\">
            Foto de avatar actualizada
          </div>";
            }else{
                echo "<div class=\"alert alert-danger text-center mx-auto w-50 mt-5\" role=\"alert\">
            Formato incorrecto, foto no actualizada
          </div>";
            }
        }
    ?>
</body>
</html>
