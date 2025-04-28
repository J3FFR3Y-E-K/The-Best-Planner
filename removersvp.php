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
    
    $sql = "DELETE FROM `rsvps` WHERE `UID` = '$uid' AND `EID` = '$eid'";
    
    $result = mysqli_query($con, $sql);
    

    if ($result) {
         $message = "RSVP Deletion Succesfull";
         header("Location: https://cyan.csam.montclair.edu/~lovei1/calendar.php?message=".$message);
         die();
    } else {
        $message = "RSVP Deletion Not Succesfull";
        header("Location: https://cyan.csam.montclair.edu/~lovei1/calendar.php?message=".$message);
         die();
    }

?>
