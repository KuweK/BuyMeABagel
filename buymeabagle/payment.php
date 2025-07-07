<?php
ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    if($_GET["count"]!=0 && $_GET["usr"]!=""){
        $count = $_GET["count"];
        $host = "localhost";
        $who = "kuwek";
        $passs = "passwd";
        $base = "php-test";
        $db = new mysqli($host, $who, $passs, $base);
        $prep = $db->prepare("SELECT name, bagels FROM users_bmab WHERE name = ?");
        $prep -> bind_param("s", $_GET["usr"]);
        $prep -> execute();
        $prep -> bind_result($nick, $bagels);
        $prep -> fetch();
        $prep -> close();
        if($nick!=""){
            $bagels += $count;
            $upd = $db -> prepare("UPDATE users_bmab SET bagels = ? WHERE name = ?");
            $upd -> bind_param("is", $bagels, $nick);
            $upd -> execute();
            $upd -> close();
            header("Location: http://".$_SERVER["HTTP_HOST"]."/buymeabagle/user.php?usr=$nick&msg=success");
        }
        $db->close();
        if($nick == ""){
            header("Location: http://".$_SERVER["HTTP_HOST"]."/buymeabagle/index.php?err=noname");
            exit;
        }
    }
?>