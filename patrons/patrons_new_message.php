<?php
    session_start();
    require_once "../square_image_creator/create_square_image.php";
    require_once "../php_functions/general.php";
    require_once "../php_functions/patrons_functions.php";
    require_once "../php_functions/login_register_functions.php";
    require_once "../php_functions/admin_functions.php";
    forbidAccess("patron");
    closeSession($_POST);

    $decoded = decodeToken($_SESSION["token"]);
    $decoded = json_decode(json_encode($decoded), true);

    $user = $decoded["data"]["user"];

    if(isset($_POST["send-patron-message"])){
        $msg = $_POST["msg"];
        $group_id = $_POST["group-id"];

        $message_sent = sendPatronMessage($msg, $user, $group_id);
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
    <link rel="stylesheet" href="../estilos.css">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js" defer></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js" defer></script>
    <script src="../scripts/patrons_send_message.js" defer></script>
    <link rel="icon" type="image/png" href="../media/assets/favicon-32x32-modified.png" sizes="32x32" />
    <title>Mecenas nuevo mensaje</title>
</head>
<body id="discografica-main">
    <div class="patrons-new-message-modal d-none position-fixed vw-100 vh-100 d-flex justify-content-center align-items-center">
        <ion-icon class="position-absolute top-0 end-0 mt-5 me-5 close-message-patron-modal" name="close-circle-outline"></ion-icon>
        <form class="d-flex flex-column gap-3" action="#" method="post">
            <textarea name="msg" id="" cols="30" rows="10"></textarea>
            <input name="group-id" hidden>
            <button style='--clr:#2ce329' name="send-patron-message" class='btn-danger-own'><span>Enviar mensaje</span><i></i></button>
        </form>
    </div>
    <?php
        menuPatronDropdown();
        
    ?>
    <h1 class="text-center mt-4 mb-4">Grupos</h1>
    <!-- <input type="text" class="busqueda-dinamica-disc"> -->
    <section class="filter-abc-admin">
        <?php
            printFilterForm("por nombre de grupo")
        ?>
    </section>
    <section class="container-fluid container-grupos-discografica row mx-auto gap-3 p-2">
        <?php
            if(isset($_POST["filter"])){
                echo "<div class=\"d-flex justify-content-center align-items-center gap-3 mb-4\">
                        <label>Búsqueda dinámica</label>
                        <input type=\"text\" class=\"busqueda-dinamica-disc\">
                    </div>";
                getPatronsGroupsFiltered($_POST["filter"], $user);
            }         
        ?>
    
    </section>
    <?php
        if(isset($message_sent)){
            if($message_sent){
                echo "<div class=\"alert alert-success text-center mt-3 w-50 mx-auto\" role=\"alert\">
                Mensaje enviado correctamente al artista.
            </div>";
            }else{
                echo "<div class=\"alert alert-danger text-center mt-3 w-50 mx-auto\" role=\"alert\">
                Se ha producido un error, no se ha podido enviar el mensaje.
            </div>";
            }
        }
    ?>
</body>
</html>
