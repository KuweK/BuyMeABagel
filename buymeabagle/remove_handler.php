<?php
    foreach($_POST as $key=>$el){
        echo "<br>$key=$el";
    }
    $cookiename = $_COOKIE["name"];
    $correctname = htmlspecialchars($_POST["name"]);
    $correctpass = md5($_POST["password"]);
    $correctemail = htmlspecialchars($_POST["email"]);
    $checker = false;
    if ($correctname === $cookiename){
        $checker = true;
    }
    if($checker==true){
        $host = "localhost";
        $who = "kuwek";
        $passs = "passwd";
        $base = "php-test";
        $db = new mysqli($host, $who, $passs, $base);
        $prep = $db->prepare("DELETE FROM users_bmab WHERE name = ? AND pass = ? AND email = ?");
        $prep->bind_param("sss", $correctname, $correctpass, $correctemail);
        $prep->execute();
        $prep->close();
        $db->close();
        setcookie("name", "", time() -3600);
        setcookie("isLogin", "false", time() -3600);
        header("Location: http://".$_SERVER["HTTP_HOST"]."/buymeabagle/index.php?err=noauth");
    }
    else{
        header("Location: http://".$_SERVER["HTTP_HOST"]."/buymeabagle/index.php?err=noautherize");
    }
?>