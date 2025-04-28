<?php
if (!$_POST) {
    header("Location: //cyan.csam.montclair.edu/~lovei1/login.html");
    die();
}

$con = new mysqli("localhost", "lovei1_iandbuser", "tfihp2371#3", "lovei1_engageeventmanager");
if ($con->connect_error) {
    die("Connection failed.");
}

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM `users` WHERE `Email` = '$email' AND `Password` = SHA1('$password')";

$result = mysqli_query($con, $sql);

if ($result->num_rows > 0) {
    $userId;
    foreach($result as $return) {
       $userId = $return['UID'];
    }
    setcookie("Login", "$userId", time() + (1800), "/");
   header("Location: //cyan.csam.montclair.edu/~lovei1/homepage.php");
   die();
} else {
    $sql = "SELECT `OrgName` FROM `organizations` WHERE `OrgEmail` = '$email' AND `OrgPassword` = SHA1('$password')";
    $result = mysqli_query($con, $sql);
    if ($result->num_rows > 0) {
        $OrgName;
        foreach($result as $return) {
            $OrgName = $return['OrgName'];
        }
        setcookie("Organization", "$OrgName", time() + (1800), "/");
        header("Location: //cyan.csam.montclair.edu/~lovei1/organization.php");
        die();
    } else {
        $sql = "SELECT `email` FROM `admins` WHERE `email` = '$email' AND `password` = SHA1('$password')";
        $result = mysqli_query($con, $sql);
        if ($result->num_rows > 0) {
            $adminEmail;
            foreach($result as $return) {
                $adminEmail = $return['email'];
            }
            setcookie("Admin", "$adminEmail", time() + (1800), "/");
            header("Location: //cyan.csam.montclair.edu/~lovei1/admin.php");
            die();
        } else {
            header("Location: //cyan.csam.montclair.edu/~lovei1/login.html");
            die();
        }
    }
}

?>

