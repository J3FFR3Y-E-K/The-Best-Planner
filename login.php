<?php
$con = new mysqli("localhost", "lovei1_iandbuser", "tfihp2371#3", "lovei1_engageeventmanager");
if ($con->connect_error) {
    die("Connection failed.");
}

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT `Email` FROM `users` WHERE `Email` = '$email' AND `Password` = SHA1('$password')";

$result = mysqli_query($con, $sql);

if ($result->num_rows > 0) {
    setcookie("Login", "Yes", time() + (1800), "/");
   header("Location: //cyan.csam.montclair.edu/~lovei1/homepage.php");
   die();
} else {
    header("Location: //cyan.csam.montclair.edu/~lovei1/login.html");
    die();
}

?>

