<?php
$con = new mysqli("localhost", "lovei1_iandbuser", "tfihp2371#3", "lovei1_engageeventmanager");
if ($con->connect_error) {
    die("Connection failed.");
}

$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];
$password = $_POST['password'];

$sql = "INSERT INTO `users` (`FirstName`, `LastName`, `Email`, `Password`) VALUES ('$fname', '$lname', '$email', SHA1('$password'))";

$rs = mysqli_query($con, $sql);

if($rs)
{
	echo "Signup succesful! Now go login";
	header("Location: //cyan.csam.montclair.edu/~lovei1/login.html");
	die();
}
else
{
	echo "Signup failed, try again.";
	header("Location: //cyan.csam.montclair.edu/~lovei1/signup.html");
	die();
}

?>
