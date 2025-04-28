<?php
setcookie("Login", "", time() - 3600, "/");
setcookie("Organization", "", time() - 3000, "/");
setcookie("Admin", "", time() - 3000, "/");
header("Location: //cyan.csam.montclair.edu/~lovei1/login.html");
die();
?>
