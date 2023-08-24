<?php
    session_start();
    require_once "../php_functions/general.php";
    require_once "../php_functions/admin_functions.php";
    forbidAccess("admin");
    closeSession($_POST);
    if(isset($_GET["ver-mas"])){
        $id = $_GET["id"];
    }elseif(isset($_GET["id"])){
        $id = $_GET["id"];
    }else{
        $error = true;
    }
    if(isset($_POST["eliminar"])){
        deletePostPhoto($_POST["id-foto"]);
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
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js" defer></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js" defer></script>
    <link rel="stylesheet" href="../estilos.css">
    <script src="" defer></script>
    <script src="../scripts/jquery-3.2.1.min.js" defer></script>
    <link rel="icon" type="image/png" href="../media/assets/favicon-32x32-modified.png" sizes="32x32" />
    <title>Document</title>
</head>
<body id="admin-body">
    <?php
        menuAdminDropdown();
        if(isset($error)){
            echo "<div class=\"alert-post-missing-info text-center alert alert-warning position-absolute\" role=\"alert\">
                    Falta información para mostrar esta sección. Vuelve al <a href=\"admin_main.php\" class=\"alert-link\">resumen general</a>.
                </div>";
        }else{
            getPost($id);
        }
        
    ?>
</body>
</html>