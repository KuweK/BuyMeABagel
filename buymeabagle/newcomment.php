<?php
ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    print_r($_POST);
    if(trim($_POST["text"])!=""){
        $correcttext = htmlspecialchars($_POST["text"]);
        $from = $_POST["from"];
        $to = $_POST["to"];
        $host = "localhost";
        $who = "kuwek";
        $passs = "passwd";
        $base = "php-test";
        $db = new mysqli($host, $who, $passs, $base);
        $prepare = $db->prepare("INSERT INTO comments_bmab (author, chanel, comment) VALUES (?, ?, ?)");
        $prepare->bind_param("sss", $from, $to, $correcttext);
        $prepare->execute();
        $prepare->close();
        $db->close();
        header("Location: http://".$_SERVER["HTTP_HOST"]."/buymeabagle/");
        exit;
    }
?>