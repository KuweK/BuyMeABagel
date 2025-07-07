<?php
    header('Content-Type: application/json; charset=utf-8');
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    if($_GET["usr"]!=""){
        $host = "localhost";
        $who = "kuwek";
        $passs = "passwd";
        $base = "php-test";
        $db = new mysqli($host, $who, $passs, $base);
        $prep = $db->prepare("SELECT name, aboutchanel FROM users_bmab WHERE name = ?");
        $prep->bind_param("s", $_GET["usr"]);
        $prep->execute();
        $prep->bind_result($nick, $desc);
        $prep->fetch();
        $prep->close();
        $db->close();
        if($nick != "" && $desc!=""){
            echo json_encode([
                "success" => true,
                "name" => $nick,
                "about" => $desc,
            ]);
        }
        else{
            echo json_encode([
                "success" => false
            ]);
        }
    }
    else {
        echo json_encode([
            "success" => false
        ]);
    }
?>