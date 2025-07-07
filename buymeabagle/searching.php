<?php
    if($_GET['q']!=""){
        $mass = [];
        $host = "localhost";
        $who = "kuwek";
        $passs = "passwd";
        $base = "php-test";
        $db = new mysqli($host, $who, $passs, $base);
        $prep = $db->prepare("SELECT name FROM users_bmab WHERE name = ?");
        $prep->bind_param("s", $_GET["q"]);
        $prep->execute();
        $prep->bind_result($nick);
        while($prep->fetch()){
            $mass[] = ['name' => $nick];
        }
        echo json_encode($mass);
        $prep->close();
        $db->close();
    }
?>