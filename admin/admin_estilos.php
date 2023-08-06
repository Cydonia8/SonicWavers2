<?php
    session_start();
    // echo $_SESSION["user"]
    require_once "../php_functions/admin_functions.php";
    require_once "../php_functions/general.php";
    forbidAccess("admin");
    if(isset($_POST["nuevo-estilo"])){
        newStyle($_POST["nombre"]);
    }
    closeSession($_POST);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous" defer></script>
    <link rel="stylesheet" href="../estilos.css">
    <script src="../scripts/admin_estilos.js" defer></script>
    <link rel="icon" type="image/png" href="../media/assets/favicon-32x32-modified.png" sizes="32x32"/>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js" defer></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js" defer></script>
    <title>Panel de administración</title>
</head>
<body id="admin-body">
    <div class="modal-form-estilo">
        <form action="#" method="post" id="form-nuevo-estilo">
            <ion-icon id="close-form-add-style" name="close-outline"></ion-icon>
            <div class="">
                <label for="">Nombre</label>
                <input type="text" required name="nombre">
            </div>
            <input type="submit" name="nuevo-estilo" value="Añadir estilo">
        </form>
    </div>
    <?php
        menuAdminDropdown();
    ?>
    
    <h1 class="text-center mt-5 mb-5">Estilos de Sonic Waves</h1>
    <!-- <button id="abrir-form-estilo">Añadir estilo</button> -->
    <div class="d-flex justify-content-center">
        <button id="abrir-form-estilo" style='--clr:#09eb3a' class='btn-danger-own' name='aprobar'><span>Añadir estilo</span><i></i></button>
    </div>
    
    <section class="estilos-container container-xl mx-auto mt-4">
        
        <?php
            getAllStyles();
        ?>
    </section>
</body>
</html>