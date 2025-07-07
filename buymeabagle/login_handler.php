<?php
if($_POST['name'] != "" && $_POST['password'] != ""){
    $host = "localhost";
    $usr = "kuwek";
    $pass = "passwd";
    $dbase = "php-test";
    $rightpass = md5(htmlspecialchars($_POST['password']));
    $rightname = htmlspecialchars(trim($_POST['name']));
    $db = new mysqli($host, $usr, $pass, $dbase);

    $prep = $db->prepare("SELECT * FROM users_bmab WHERE name = ? AND pass = ?");
    $prep->bind_param("ss", $rightname, $rightpass);
    $prep->execute();
    $prep->store_result();
    if($prep->num_rows()>=1){
        setcookie("name", $rightname, time() + 3600);
        setcookie("isLogin", "true", time() + 3600);
        header("Location: "."http://localhost/buymeabagle/index.php");
    }
    elseif($prep->num_rows()<1){
        header("Location: http://localhost/buymeabagle/login.php?msg=err");
    }
    $prep->close();
    $db->close();
}
?>