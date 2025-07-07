<?php
$host = "localhost";
$usr = "kuwek";
$pass = "passwd";
$dbase = "php-test";

$db = new mysqli($host, $usr, $pass, $dbase);

if (isset($_GET['name']) && trim($_GET['name']) !== "") {
    $correctname = htmlspecialchars(trim($_GET['name']));
    $stmt = $db->prepare("SELECT id FROM users_bmab WHERE name = ?");
    $stmt->bind_param("s", $correctname);
    $stmt->execute();
    $stmt->store_result();
    echo ($stmt->num_rows > 0) ? "taken" : "available";
    $stmt->close();
}

else if (isset($_GET['email']) && trim($_GET['email']) !== "") {
    $correctemail = htmlspecialchars(trim($_GET['email']));
    $stmt = $db->prepare("SELECT id FROM users_bmab WHERE email = ?");
    $stmt->bind_param("s", $correctemail);
    $stmt->execute();
    $stmt->store_result();
    echo ($stmt->num_rows > 0) ? "taken" : "available";
    $stmt->close();
}

$db->close();
?>
