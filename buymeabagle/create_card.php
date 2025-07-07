<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$correct_desc = htmlspecialchars(trim($_POST["description"]));
$correct_pass = md5($_POST["password"]);

if($correct_desc==""){
    header("Location: http://".$_SERVER['HTTP_HOST']."/buymeabagle/index.php?err=nodesc");
    exit;
}
elseif($correct_desc!=""){
    $host = "localhost";
    $who = "kuwek";
    $passs = "passwd";
    $base = "php-test";

    $db = new mysqli($host, $who, $passs, $base);
    $prep = $db->prepare("SELECT name FROM users_bmab WHERE pass = ?");
    $prep->bind_param("s", $correct_pass);
    $prep->execute();
    $prep->bind_result($nameindb);
    $prep->fetch();
    $prep->close();
    $db->close();
    if($_COOKIE["isLogin"] =="true" && $nameindb==$_COOKIE["name"]) {   
        $db = new mysqli($host, $who, $passs, $base);
        $prep = $db->prepare("UPDATE users_bmab SET aboutchanel = ? WHERE pass = ? AND name = ?");
        $prep->bind_param("sss", $correct_desc, $correct_pass, $_COOKIE["name"]);
        $prep->execute();
        $prep->close();
        $db->close();
        header("Location: http://".$_SERVER["HTTP_HOST"]."/buymeabagle/profile.php");
        exit;
    }
    else{
        header("Location: http://".$_SERVER["HTTP_HOST"]."/buymeabagle?err=noautherize");
    }
}
?>