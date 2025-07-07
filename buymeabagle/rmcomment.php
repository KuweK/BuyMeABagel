<?php
        ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    if($_COOKIE["isLogin"]=="true"&&$_COOKIE["name"]==$_POST["from"]){
        $host = "localhost";
        $who = "kuwek";
        $passs = "passwd";
        $base = "php-test";
        $db = new mysqli($host, $who, $passs, $base);
        $prep = $db->prepare("DELETE FROM comments_bmab WHERE author = ? and comment = ?");
        $prep->bind_param("ss", $_POST["from"], $_POST["text"]);
        $prep->execute();
        $prep->close();
        $db->close();
        echo json_encode([
            "success"=>true,
        ]);
    }
?>  