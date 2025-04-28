<?php
        if(!isset($_COOKIE["Organization"])) {
             header("Location: https://cyan.csam.montclair.edu/~lovei1/login.html");
             die();
        }

$con = new mysqli("localhost", "lovei1_iandbuser", "tfihp2371#3", "lovei1_engageeventmanager");
if ($con->connect_error) {
    die("Connection failed.");
}

$id = $_POST['eventID'];

$sql = "DELETE FROM `events` WHERE `EID` = '$id'";

$rs = mysqli_query($con, $sql);

if($rs)
{
    $message = "Event Deleted Succesfully";
    header("Location: https://cyan.csam.montclair.edu/~lovei1/orgeventlist.php?message=".$message);
	die();
}
else
{
	session_start();
    $message = "Event Could Not Be Deleted";
    header("Location: https://cyan.csam.montclair.edu/~lovei1/orgeventlist.php?message=".$message);
	die();
}

?>
