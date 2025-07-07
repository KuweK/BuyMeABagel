<?php
    if($_COOKIE["isLogin"]=="true"){
        $correct_name = htmlspecialchars($_COOKIE["name"]);
        $correct_desc = htmlspecialchars($_POST["newdesc"]);
        if($correct_desc==""){
            header("Location: http://".$_SERVER["HTTP_HOST"]."/buymeabagle/?err=nodesc");
            exit;
        }
        $host = "localhost";
        $who = "kuwek";
        $passs = "passwd";
        $base = "php-test";
        $db = new mysqli($host, $who, $passs, $base);
        $prep = $db->prepare("UPDATE users_bmab SET aboutchanel = ? WHERE name = ?");
        $prep->bind_param("ss", $correct_desc, $correct_name);
        $prep->execute();
        $prep->close();
        $db->close();
        header("Location: http://".$_SERVER["HTTP_HOST"]."/buymeabagle/profile.php");
        exit;
    }
    else{
        header("Location: http://".$_SERVER["HTTP_HOST"]."/buymeabagle/?err=noauth");
        exit;
    }
?>