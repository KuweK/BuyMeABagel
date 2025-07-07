<?php
    if($_COOKIE["isLogin"]=="true"&&$_COOKIE["name"]!=""){
        $host = "localhost";
        $who = "kuwek";
        $passs = "passwd";
        $base = "php-test";
        $db = new mysqli($host, $who, $passs, $base);
        $prep = $db->prepare("SELECT bagels FROM users_bmab WHERE name = ?");
        $prep->bind_param("s", $_COOKIE["name"]);
        $prep->execute();
        $prep->bind_result($bagels);
        $prep->fetch();
        $prep->close();
        $db->close();
        $mass = ["bagels"=>$bagels];
        echo json_encode([
            "bagels"=>$bagels
        ]);
    }
    else{
        header("Location: http://".$_SERVER["HTTP_HOST"]."/buymeabagle/index.php?err=noauth");
    }
?>