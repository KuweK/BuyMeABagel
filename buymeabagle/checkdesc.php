<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if($_COOKIE["isLogin"]=="true"){
    $host = "localhost";
    $who = "kuwek";
    $passs = "passwd";
    $base = "php-test";
    $db = new mysqli($host, $who, $passs, $base);
    $prep = $db->prepare("SELECT aboutchanel FROM users_bmab WHERE name = ?");
    $prep->bind_param("s", $_COOKIE["name"]);
    $prep->execute();
    $prep->bind_result($desc);
    $prep->fetch();
    if($desc!=""){
        echo "has";
    }
    else{
        echo "nohas";
    }
}
else {
    echo "nohas";
}
?>