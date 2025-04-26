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
	echo "Signup succesful! <a href='//cyan.csam.montclair.edu/~lovei1/login.html'>Now please login here!</a>";
	header("Location: //cyan.csam.montclair.edu/~lovei1/login.html");
	die();
}
else
{
	echo "Signup failed, <a href='//cyan.csam.montclair.edu/~lovei1/signup.html'>please try again.</a>";
	header("Location: //cyan.csam.montclair.edu/~lovei1/signup.html");
	die();
}

?>
