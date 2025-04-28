<?php
        if(!isset($_COOKIE["Login"])) {
             header("Location: https://cyan.csam.montclair.edu/~lovei1/login.html");
             die();
        }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f3f4f6;
            text-align: center;
        }
        .navbar {
            background-color: #e01822;
            padding: 15px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .navbar a {
            margin: 0 15px;
            text-decoration: none;
            color: white;
            font-weight: bold;
        }
        .hero {
            padding: 100px 20px;
        }
        .hero h2 {
            font-size: 2.5em;
            color: #1f2937;
        }
        .hero p {
            color: #e01822;
            font-size: 1.2em;
        }
        .hero-image {
            width: 100%;
            max-width: 600px;
            height: auto;
            margin-top: 20px;
            border-radius: 10px;
        }
        .button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #3b82f6;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
        .features {
            background-color: white;
            padding: 50px 20px;
        }
        .footer {
            background-color: #e01822;
            color: white;
            padding: 20px;
            margin-bottom: 20px;
        }
        
        table {
          size: 50%;
          margin-left: 15%;
          border-collapse: collapse;
          border-spacing: 5px;
          padding: 10px;
        }

        th, td {
          border: 1px solid black;
          padding: 10px;
        }
        
        .message {
          margin: 20px 0;
          padding: 10px;
          background:rgb(166, 207, 173);
          color: black;
          border-radius: 4px;
          text-align: center;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <a href="./homepage.php">Home</a>
        <a href="./events.php">Events</a>
        <a href="./calendar.php">Calendar</a>
        <a href="./contact.php">Contact</a>
        <a href="./signout.php">Sign Out</a>
    </nav>
    <br>
    <h1>Current RSVP's</h1>
    <br>
    <?php if($_GET): ?>
        <div class = "message">
            <?php
                    echo $_GET['message'];      
            ?>
        </div>
        <br>
    <?php endif; ?>
    <table id = "table">
    <tr>
        <th>Event Name</th>
        <th>Organization Name</th>
        <th>Event Description</th>
        <th>Start Time</th>
        <th>End Time</th>
        <th>Location</th>
    </tr>
    <?php
        $con = new mysqli("localhost", "lovei1_iandbuser", "tfihp2371#3", "lovei1_engageeventmanager");
        if ($con->connect_error) {
            die("Connection failed.");
        }
        $login = $_COOKIE['Login'];
        $sql = "SELECT * FROM rsvps WHERE `UID` = '$login'";
        $result = mysqli_query($con,$sql);
        
        if (!$result) {
            echo 'MySQL Error: ' . mysqli_error($con);
            exit;
        }
        
        foreach ($result as $rsvp) { ?>
        <?php 
        $eid = $rsvp['EID'];
        /*?><script>alert(<?php echo $eid; ?>);</script><?php*/
         $sql = "SELECT * FROM `events` WHERE `EID` = '$eid';";
         $eventDetails = mysqli_query($con,$sql);
         foreach ($eventDetails as $event) {
        ?>
        <tr>
        <td><?php echo $event['Name']; ?></td>
        <td><?php echo $event['Organization']; ?></td>
        <td><?php echo $event['Description']; ?></td>
        <td><?php echo $event['TimeStart']; ?></td>
        <td><?php echo $event['TimeEnd']; ?></td>
        <td><?php echo $event['Location']; ?></td>
        <td>
            <form name = "delete" method="post" action="removersvp.php">
            <input type="hidden" name="eventID" value= "<?php echo $event['EID']; ?>">
            <input type = "submit" value = "Remove">
            </form>
        </td>
        <td>
            <form name = "addto" method="post" action="addtocalendar.php">
            <input type="hidden" name="name" value= "<?php echo $event['Name']; ?>">
            <input type="hidden" name="desc" value= "<?php echo $event['Description']; ?>">
            <input type="hidden" name="loc" value= "<?php echo $event['Location']; ?>">
            <input type="hidden" name="ts" value= "<?php echo $event['TimeStart']; ?>">
            <input type="hidden" name="te" value= "<?php echo $event['TimeEnd']; ?>">
            <input type = "submit" value = "Add to Calendar">
            </form>
        </td>
        </tr>
        <?php }} ?>
    </table>
        
    <br>
    <footer class="footer">
        <p>&copy; 2025 Software Engineer II Project.</p>
    </footer>
</body>
</html>
