<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$host = "localhost";
$who = "kuwek";
$passs = "passwd";
$base = "php-test";
$db = new mysqli($host, $who, $passs, $base);
$prep = $db->prepare("SELECT name, LEFT(aboutchanel, 50) AS short_desc FROM users_bmab WHERE aboutchanel IS NOT NULL AND aboutchanel != '' ORDER BY RAND() LIMIT 6");
$prep->execute();
$prep->bind_result($savename, $saveshort);
$mass = [];
while($prep->fetch()){
    $mass[] = ['name'=>$savename, 'short_desc'=>$saveshort];
}
header('Content-Type: application/json');
echo json_encode($mass);
?>