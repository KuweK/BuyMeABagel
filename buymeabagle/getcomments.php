<?php
    if($_GET["usr"]!=""){
        $correctname = $_GET["usr"];
        $mass = [];
        $result = [];
        $isyour = false;
        $host = "localhost";
        $who = "kuwek";
        $passs = "passwd";
        $base = "php-test";
        $db = new mysqli($host, $who, $passs, $base);
        $prep = $db->prepare("SELECT author, comment FROM comments_bmab WHERE chanel = ?");
        $prep->bind_param("s", $correctname);
        $prep->execute();
        $prep->bind_result($from, $text);
        while($prep->fetch()){
            if($_COOKIE["name"]===$from){
                $isyour = true;
            }
            else{
                $isyour = false;
            }
            $mass[] = ["from" => $from, "text" => $text, "your" => $isyour];
        }
        $prep->close();
        $db->close();
        header('Content-Type: application/json');
        echo json_encode([
            "success" => true,
            "comments" => $mass,
        ]);
    }
?>