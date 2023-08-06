<?php
session_start();
    require_once "../php_functions/login_register_functions.php";
    if(isset($_SESSION["user"])){
        header("Location:../index.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="text/javascript" src="../scripts/jquery-3.2.1.min.js" defer></script>
    <script src="../scripts/registro.js" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../estilos.css">
    <link rel="icon" type="image/png" href="../media/assets/favicon-32x32-modified.png" sizes="32x32" />
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js" defer></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js" defer></script>
    <title>Registro en Sonic Waves</title>
</head>
<body id="login">
    <header class="w-100 position-absolute d-flex justify-content-center p-4">
        <a class="text-center" href="../index.php">
            <img src="../media/assets/sonic-waves-high-resolution-logo-color-on-transparent-background (1).png" alt="">
        </a>
    </header>
    <section class="h-100 w-100 d-flex justify-content-center align-items-center">
        <div class="form-box w-50">
            <div class="form-option-picker d-flex justify-content-between flex-wrap mb-3 align-content-center">
                <h3 class="active text-center flex-grow-1" data-form-title="user">Usuario</h3>
                <h3 class="text-center flex-grow-1" data-form-title="group">Grupo</h3>
                <h3 class="text-center flex-grow-1" data-form-title="disc">Discográfica</h3>
            </div>
            <div class="forms-container border border-secondary d-flex flex-column align-items-center p-2">
                <form action="#" method="post" class="active-form" data-form="user">
                    <h2 class="text-center mb-5 mt-3">Registro para usuarios</h2>
                    <div class="input-field d-flex flex-column mb-3">
                        <div class="input-visuals d-flex justify-content-between">
                            <label for="usuario">Usuario</label>
                            <ion-icon name="person-outline"></ion-icon>
                        </div>
                        <input name="usuario" type="text" required>                        
                    </div>
                    <div class="input-field d-flex flex-column mb-3">
                        <div class="input-visuals d-flex justify-content-between">
                            <label for="nombre">Nombre</label>
                            <ion-icon name="person-outline"></ion-icon>
                        </div>
                        <input name="nombre" type="text" required>                        
                    </div>
                    <div class="input-field d-flex flex-column mb-3">
                        <div class="input-visuals d-flex justify-content-between">
                            <label for="apellidos">Apellidos</label>
                            <ion-icon name="person-outline"></ion-icon>
                        </div>
                        <input name="apellidos" type="text" required>                        
                    </div>
                    <div class="input-field d-flex flex-column mb-3">
                        <div class="input-visuals d-flex justify-content-between">
                        <label for="pass">Contraseña</label>
                        <ion-icon name="lock-closed-outline"></ion-icon>
                    </div>
                        <div class="pass-row d-flex position-relative">
                            <input class="w-100" name="pass" type="password" required>
                            <ion-icon class="position-absolute end-0 view-pass" name="eye-outline"></ion-icon>
                        </div>
                    </div>
                    <div class="input-field d-flex flex-column mb-3">
                        <div class="input-visuals d-flex justify-content-between">
                        <label for="pass">Correo electrónico</label>
                        <ion-icon name="mail-outline"></ion-icon>
                    </div>
                        <input class="w-100" name="mail" type="email" required>
                    </div>
                    <input type="submit" name="registro-user" value="Crear cuenta" class="w-100 rounded-pill border-0 mb-3 p-2">
                    <div class="register">
                        <p class="text-center">¿Ya tienes cuenta? <a class="text-white" href="login.php">Accede aquí</a></p>
                    </div>
                </form>

                <form action="#" data-form="group" method="post">
                    <h2 class="text-center mb-5 mt-3">Registro para grupos</h2>
                    <div class="input-field d-flex flex-column mb-3">
                        <div class="input-visuals d-flex justify-content-between">
                            <label for="nombre">Nombre del grupo</label>
                            <ion-icon name="radio-outline"></ion-icon>
                        </div>
                        <input name="nombre" type="text" required>                        
                    </div>
                    <div class="input-field d-flex flex-column mb-3">
                        <div class="input-visuals d-flex justify-content-between">
                            <label for="mail">Correo electrónico</label>
                            <ion-icon name="mail-outline"></ion-icon>
                        </div>
                        <input name="mail" type="email" required>                        
                    </div>
                    <div class="input-field d-flex flex-column mb-3">
                        <div class="input-visuals d-flex justify-content-between">
                        <label for="pass">Contraseña</label>
                        <ion-icon name="lock-closed-outline"></ion-icon>
                    </div>
                    <div class="pass-row d-flex position-relative">
                            <input class="w-100" name="pass" type="password" required>
                            <ion-icon class="position-absolute end-0 view-pass" name="eye-outline"></ion-icon>
                        </div>
                    </div>
                    <input data-form="group" id="boton-registro-grupo" type="submit" name="registro-grupo" value="Crear cuenta" class="w-100 rounded-pill border-0 mb-3 p-2">
                    <div class="register">
                        <p class="text-center">¿Ya tienes cuenta? <a class="text-white" href="login.php">Accede aquí</a></p>
                    </div>
                </form>

                <form action="#" data-form="disc" method="post">
                    <h2 class="text-center mb-5 mt-3">Registro para discográficas</h2>
                    <div class="input-field d-flex flex-column mb-3">
                        <div class="input-visuals d-flex justify-content-between">
                            <label for="nombre">Nombre de la discográfica</label>
                            <ion-icon name="radio-outline"></ion-icon>
                        </div>
                        <input name="nombre" type="text" required>                        
                    </div>
                    <div class="input-field d-flex flex-column mb-3">
                        <div class="input-visuals d-flex justify-content-between">
                            <label for="mail">Correo electrónico</label>
                            <ion-icon name="mail-outline"></ion-icon>
                        </div>
                        <input name="mail" type="email" required>                        
                    </div>
                    <div class="input-field d-flex flex-column mb-3">
                        <div class="input-visuals d-flex justify-content-between">
                        <label for="pass">Contraseña</label>
                        <ion-icon name="lock-closed-outline"></ion-icon>
                    </div>
                    <div class="pass-row d-flex position-relative">
                            <input class="w-100" name="pass" type="password" required>
                            <ion-icon class="position-absolute end-0 view-pass" name="eye-outline"></ion-icon>
                        </div>
                    </div>
                    <input type="submit" name="registro-disc" value="Crear cuenta" class="w-100 rounded-pill border-0 mb-3 p-2">
                    <div class="register">
                        <p class="text-center">¿Ya tienes cuenta? <a class="text-white" href="login.php">Accede aquí</a></p>
                    </div>
                </form>
            </div>
            <?php
                if(isset($_POST["registro-user"])){
                    $user = $_POST["usuario"];
                    $nombre = $_POST["nombre"];
                    $apellidos = $_POST["apellidos"];
                    $pass = $_POST["pass"];
                    $mail = $_POST["mail"];
                    $user_exists = userNameRepeated($_POST["usuario"]);
                    $mail_exists = mailRepeated($mail, "usuario");
                    // echo "<meta http-equiv='refresh' content='0;url=../index.php'>";
                    if(!$user_exists and !$mail_exists){
                        insertNewUser($user, $nombre, $apellidos, $pass, $mail, 0, 0);
                        echo "<div class=\"alert text-center mt-3 alert-success alert-dismissible fade show\" role=\"alert\">Usuario creado correctamente.</div>";
                    }else{
                        echo "<div class=\"alert text-center mt-3 alert-danger alert-dismissible fade show\" role=\"alert\">Usuario o correo ya registrados</div>";
                    }
                }elseif(isset($_POST["registro-grupo"])){
                    $nombre_grupo = $_POST["nombre"];
                    $pass = $_POST["pass"];
                    $mail = $_POST["mail"];
                    // echo "<meta http-equiv='refresh' content='0;url=../index.php'>";
                    $mail_exists = mailRepeated($mail, "grupo");

                    if(!$mail_exists){
                        insertNewGroup($nombre_grupo, $pass, $mail, 0);
                        echo "<div class=\"alert text-center mt-3 alert-success alert-dismissible fade show\" role=\"alert\">Solicitud de grupo registrada y a la espera de ser aprobada.</div>";
                    }else{
                        echo "<div class=\"alert text-center mt-3 alert-danger alert-dismissible fade show\" role=\"alert\">Correo ya registrado</div>";
                    }
                }elseif(isset($_POST["registro-disc"])){
                    $nombre_discografica = $_POST["nombre"];
                    $pass = $_POST["pass"];
                    $mail = $_POST["mail"];
                    $mail_exists = mailRepeated($mail, "discografica");

                    if(!$mail_exists){
                        insertNewDiscographic($nombre_discografica, $pass, $mail);
                        echo "<div class=\"alert text-center mt-3 alert-success alert-dismissible fade show\" role=\"alert\">Solicitud de discográfica registrada y a la espera de ser aprobada.</div>";
                    }else{
                        echo "<div class=\"alert text-center mt-3 alert-danger alert-dismissible fade show\" role=\"alert\">Correo ya registrado</div>";
                    }
                }
            ?>
        </div>
    </section>
   
</body>
</html>