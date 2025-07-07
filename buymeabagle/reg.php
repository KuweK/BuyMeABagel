<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$correct_name = htmlspecialchars(trim($_POST['name']));
$passwordnomd5 = htmlspecialchars(trim($_POST['password']));
$correct_password = md5($passwordnomd5);
$correct_email = htmlspecialchars(trim($_POST['email']));
$correct_data = [$correct_name, $correct_password, $correct_email];

echo "<h1>Если вы не были переадресованы, произошла ошибка! Убедитесь в правильности написания данных или повторите попытку позже.</h1>";

$host = "localhost";
$usr = "kuwek";
$pass = "passwd";
$dbase = "php-test";

$db = new mysqli($host, $usr, $pass, $dbase);

if($db->connect_error!=""){
    echo $db->connect_error." ".$db->connect_errno; 
}
else{
    $stmt = $db->prepare("INSERT INTO users_bmab (name, pass, email, aboutchanel, bagels) VALUES (?, ?, ?, '', 0)");
    $stmt->bind_param("sss", $correct_name, $correct_password, $correct_email);
    $stmt->execute();
    $stmt->close();
    setcookie("isLogin", "true", time() + 3600);
    setcookie("name", $correct_name, time() + 3600);
    header("Location: "."http://".$_SERVER['HTTP_HOST']."/buymeabagle");
}

$db->close();

?>