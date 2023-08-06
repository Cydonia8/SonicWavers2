<?php
    session_start();
    require_once "../php_functions/group_functions.php";
    require_once "../php_functions/general.php";
    forbidAccess("group");
    closeSession($_POST);
    $miembros = groupHasMembers($_SESSION["user"]);

    if(isset($_POST["agregar"])){
        $usuario = $_POST["usuario"];
        
        $es_miembro = userIsMember($usuario);
        $existe = userExists($usuario);
        if($existe == 1 and $es_miembro == 0){
            addNewMember($usuario, $_SESSION["user"]);
        }
    }
    elseif(isset($_POST["eliminar-miembro"])){
        $id = $_POST["usuario"];
        $eliminado = removeMember($id);
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
    <script src="../scripts/jquery-3.2.1.min.js" defer></script>
    <script src="../scripts/grupo_miembros.js" defer></script>
    <link rel="icon" type="image/png" href="../media/assets/favicon-32x32-modified.png" sizes="32x32" />
    <title>Document</title>
</head>
<body id="grupo-miembros">
    <?php
        menuGrupoDropdown("position-static");
    ?>
    <section class="container-xl">
        <h1 class="text-center mb-4">Miembros del grupo</h1>
        <div class="d-flex flex-column flex-md-row group-members-container">
            <div class="w-50">
                <h2 class="text-center mb-5">Agregar nuevo miembro</h2>
                <form class="d-flex flex-column align-items-center mt-3" action="#" method="post">
                    <div class="input-field d-flex flex-column mb-3 w-75 gap-3">
                        <div class="input-visuals d-flex justify-content-between">
                            <label for="usuario">Nombre de usuario</label>
                            <ion-icon name="radio-outline"></ion-icon>
                        </div>
                        <input type="text" name="usuario" placeholder="Nombre de usuario" required>                    
                    </div>
                    
                    <input type="submit" name="agregar" value="Agregar miembro">
                </form>
                <?php
                    if(isset($existe)){
                        if($existe == 0){
                            echo "<div class=\"alert alert-danger text-center mt-3 w-50 mx-auto\" role=\"alert\">
                                Este usuario no existe en Sonic Waves
                            </div>";
                        }else{
                            if(isset($es_miembro) and $es_miembro != 0){
                                echo "<div class=\"alert alert-danger text-center mt-3 w-50 mx-auto\" role=\"alert\">
                                Este usuario ya pertenece a otro grupo
                            </div>";
                            }else{
                                echo "<div class=\"alert alert-success text-center mt-3 w-50 mx-auto\" role=\"alert\">
                                Usuario agregado como miembro de grupo
                            </div>";
                            header("Refresh:0; url=grupo_miembros.php");
                            }
                        }
                        
                    }
                ?>
            </div>
            <div class="w-50 d-flex flex-column align-items-center gap-3">
                <h2 class="text-center mb-5">Miembros actuales</h2>
                <?php
                    if($miembros == 0){
                        echo "<h3 class='text-center'>No hay miembros actualmente</h3>";
                    }else{
                        getGroupMembers($_SESSION["user"]);
                    }
                    if(isset($eliminado) and $eliminado){
                        echo "<div class=\"alert alert-danger text-center mt-3 w-50 mx-auto\" role=\"alert\">
                                Usuario eliminado correctamente.
                            </div>";
                    }
                ?>
            </div>
        </div>
    </section>
</body>
</html>