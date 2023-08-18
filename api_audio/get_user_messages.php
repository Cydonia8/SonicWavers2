<?php
    require_once "../php_functions/login_register_functions.php";
    session_start();
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin:*");

    $decoded = decodeToken($_SESSION["token"]);
    $decoded = json_decode(json_encode($decoded), true);

    $user = $decoded["data"]["user"];

    $con = new mysqli('localhost', 'root', '', 'sonicwaves');
    $query = $con->prepare("SELECT content, m_date, estado, g.nombre name_group, mrm.mensaje id_msg from grupo g, group_messages gm, member_receives_message mrm, usuario u where g.id = gm.group
    and gm.id = mrm.mensaje and mrm.usuario = u.id and u.usuario = ? order by m_date desc");
    $query->bind_param('s', $user);
    $query->execute();
    $row_messages = $query->get_result();

    $msgs = [];

    while($row = $row_messages->fetch_assoc()){
        $msgs[] = $row;
    }

    $query->close();
    $data["messages"] = $msgs;
    $con->close();
    echo json_encode($data);
?>