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
/*?><script>alert(<?php echo $id; ?>);</script><?php*/
$sql = "DELETE FROM `events` WHERE `EID` = '$id'";

$rs = mysqli_query($con, $sql);

$sql2 = "DELETE FROM `rsvps` WHERE `EID` = '$id'";
$rs2 = mysqli_query($con, $sql2);

if($rs && $rs2)
{
    $message = "Event Deleted Succesfully";
    header("Location: https://cyan.csam.montclair.edu/~lovei1/orgeventlist.php?message=".$message);
	die();
}
elseif($rs && !$rs2)
{
    $message = "Event Deleted, but RSVP's not deleted";
    header("Location: https://cyan.csam.montclair.edu/~lovei1/orgeventlist.php?message=".$message);
	die();
} else
{
    $message = "Event Couldn't Be Deleted";
    header("Location: https://cyan.csam.montclair.edu/~lovei1/orgeventlist.php?message=".$message);
	die();
}

?>
