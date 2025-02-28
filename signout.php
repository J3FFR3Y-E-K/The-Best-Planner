<?php
setcookie("Login", "", time() - 3600, "/");
header("Location: //cyan.csam.montclair.edu/~lovei1/login.html");
die();
?>