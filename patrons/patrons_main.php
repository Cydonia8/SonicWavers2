<?php
    session_start();
    require_once "../square_image_creator/create_square_image.php";
    require_once "../php_functions/general.php";
    require_once "../php_functions/patrons_functions.php";
    require_once "../php_functions/group_functions.php";
    require_once "../php_functions/login_register_functions.php";
    forbidAccess("patron");
    closeSession($_POST);

    $decoded = decodeToken($_SESSION["token"]);
    $decoded = json_decode(json_encode($decoded), true);

    $user = $decoded["data"]["user"];


    if(isset($_POST["update-avatar"])){
        $avatar_ok = checkPhoto("foto-avatar-nueva");
        if($avatar_ok){
            $avatar = newPhotoPathAvatarPatron("foto-avatar-nueva", "avatar", $user);
            updatePatronAvatarPhoto($user, $avatar);
            $avatar_updated = true;
        }else{
            $avatar_updated = false;
        }
    }
    if(isset($_POST["update-data"])){
        $pass = $_POST["pass"] != '' ? $_POST["pass"] : $_POST["pass-original"];
        $updated = updatePatronData($user, $pass);
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
    <title>Mecenas | Perfil</title>
</head>
<body id="discografica-main">
    <?php
        menuPatronDropdown();
    ?>
    <h1 class="mt-3 text-center">Mecenas</h1>
    <section>
        
        <?php
            getPatronInformation($user);
        ?>
    </section>
    <?php
        if(isset($updated) and $updated){
            echo "<div class=\"alert alert-success text-center mx-auto w-50 mt-5\" role=\"alert\">
            Datos modificados correctamente
          </div>";
        }

        if(isset($avatar_updated)){
            if($avatar_updated){
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
