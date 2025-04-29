<?php
    if(!isset($_COOKIE["Admin"])) {
         header("Location: https://cyan.csam.montclair.edu/~lovei1/login.html");
         die();
    }
    
    $con = new mysqli("localhost", "lovei1_iandbuser", "tfihp2371#3", "lovei1_engageeventmanager");
    if ($con->connect_error) {
        die("Connection failed.");
    }

    function generateRandomString($length = 16) {
        return substr(bin2hex(random_bytes($length)), 0, $length);
    }
    
    $json = './events.json';
    $eventsData = file_get_contents($json);
    $eventsList = json_decode($eventsData, true);
    
    if (json_last_error() === JSON_ERROR_NONE) {
        foreach ($eventsList as $event => $value) {
            $name = $value['title'];
            $name = str_replace('"','`', $name);
            $name = str_replace("'","`", $name);
            
            $org = $value['organization'];
            $org = str_replace('"','`', $org);
            $org = str_replace("'","`", $org);
            
            $sql = "SELECT * FROM `organizations` WHERE `OrgName` = '$org'";
            $rs = mysqli_query($con, $sql);
            if($rs->num_rows == 0) {
                $orgDesc = "An organization of Montclair State University";
                $orgEmail = (generateRandomString(16)."@gmail.com");
                $orgPassword = generateRandomString(16);
                $sql = "INSERT INTO `organizations` (`OrgName`, `OrgDescription`, `OrgEmail`, `OrgPassword`) VALUES ('$org', '$orgDesc', '$orgEmail', '$orgPassword')";
                $rs = mysqli_query($con, $sql);
                if ($rs) {
                    echo ('<p style="color: black;">New org '.$org.' succesfully added to database</p>');
                } else {
                    echo ('<p style="color: orange;">New org '.$org.' couldnt be added to database. Error: </p>'.$con-error);
                }
            } else {
                echo ('<p style="color: pink;">Database already found in system.</p>');
            }
            
            $description = $value['description'];
            $description = str_replace('"','`', $description);
            $description = str_replace("'","`", $description);
            
            $date = $value['date'];
            $start = new DateTime("$date");
            $start = $start->format('Y-m-d H:i:s');
            $end = date('Y-m-d H:i:s', strtotime($start . ' +2 hours'));
            
            $location = $value['location'];
            $location = str_replace('"','`', $location);
            $location = str_replace("'","`", $location);
            
            $sql = "SELECT * FROM `events` WHERE `Name` = '$name' AND `Timestart` = '$start'";
            $rs = mysqli_query($con, $sql);
            if($rs->num_rows == 0) {
                $sql = "INSERT INTO `events` (`Name`, `Organization`, `Description`, `Timestart`, `TimeEnd`, `Location`) VALUES ('$name', '$org', '$description', '$start', '$end', '$location')";
                #echo "$name | $org | $description | $start | $end | $location | $sql";
                ?><html><br></html><?php
                
                $rs = mysqli_query($con, $sql);
                if (!$rs) {
                    echo ('<p style="color: red;">Event: '.$name.'was NOT succesfully added. Error: </p>'.$con->error);
                } else {
                    echo '<p style="color: green;">Event: '.$name.' was succesfully added.</p>';
                }
                
            } else {
                echo '<p style="color: blue;">Event: '.$name.' is already in the database.</p>';
            }
        }
    } else {
        echo "Error decoding JSON: " . json_last_error_msg();
    }
?>
