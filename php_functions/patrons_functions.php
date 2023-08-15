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
?>