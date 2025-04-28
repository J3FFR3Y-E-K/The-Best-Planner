<?php
    if(!isset($_COOKIE["Login"])) {
         header("Location: https://cyan.csam.montclair.edu/~lovei1/login.html");
         die();
    }
        
    $con = new mysqli("localhost", "lovei1_iandbuser", "tfihp2371#3", "lovei1_engageeventmanager");
    if ($con->connect_error) {
        die("Connection failed.");
    }
        
    $uid = $_COOKIE["Login"];
    $eid = $_POST['eventID'];
    
    $sql = "SELECT * FROM `rsvps` WHERE `UID` = '$uid' AND `EID` = '$eid'";
    
    $result = mysqli_query($con, $sql);
    if($result->num_rows > 0) {
        $message = "Already RSVP'd!";
        header("Location: https://cyan.csam.montclair.edu/~lovei1/events.php?message=".$message);
        die();
    }
    
    $sql = "INSERT INTO `rsvps`(`UID`, `EID`) VALUES ('$uid','$eid')";

    $result = mysqli_query($con, $sql);
    
    $sql = "SELECT * FROM `rsvps` WHERE `UID` = '$uid' AND `EID` = '$eid'";
    
    $result = mysqli_query($con, $sql);
    
    if ($result->num_rows > 0) {
         $message = "RSVP Succesfull";
         header("Location: https://cyan.csam.montclair.edu/~lovei1/events.php?message=".$message);
         die();
    } else {
        $message = "RSVP Not Succesfull";
        header("Location: https://cyan.csam.montclair.edu/~lovei1/events.php?message=".$message);
         die();
    }

?>
