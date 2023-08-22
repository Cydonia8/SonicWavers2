<?php
    require_once "../php_functions/login_register_functions.php";
    session_start();
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin:*");

    $decoded = decodeToken($_SESSION["token"]);
    $decoded = json_decode(json_encode($decoded), true);

    $user = $decoded["data"]["user"];

    $con = createConnection();
    $query = $con->prepare("SELECT content, m_date, state, g.name name_group, mrm.message id_msg from artist g, group_messages gm, member_receives_message mrm, user u where g.id = gm.group
    and gm.id = mrm.message and mrm.user = u.id and u.username = ? order by m_date desc");
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