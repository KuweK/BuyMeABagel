<?php
setcookie("isLogin", "", time() - 15);
setcookie("name", "", time() - 15);

// После этого, чтобы не использовать старые $_COOKIE:
header("Location: http://localhost/buymeabagle/index.php");
exit;
?>