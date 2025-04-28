<?php
         if (!isset($_COOKIE["Organization"])) {
             header("Location: https://cyan.csam.montclair.edu/~lovei1/login.html");
             die();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events</title>
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
            margin-top: 20px;
        }
        
        table {
          size: 50%;
          margin-left: 20%;
          padding: 10px;
          border-collapse: collapse;
          border-spacing: 5px;
        }

        th, td {
          border: 1px solid black;
          padding: 10px;
        }
        
        input {
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
            <a href="organization.php">Home</a>
            <a href="signout.php">Sign Out</a>
        </nav>

    <header class="hero">
        <h2>Events</h2>
    </header>
    <input type="text" id="search" placeholder="Search for your events" size=70 onkeyup='searchbar()'>
    <br>
    <?php if($_GET): ?>
        <div class = "message">
            <?php
                    echo $_GET['message'];      
            ?>
        </div>
        <?php endif; ?>
        <br>
    <table id = "table">
    <tr>
        <th>Event Name</th>
        <th>Event Description</th>
        <th>Start Time</th>
        <th>End Time</th>
        <th>Location</th>
        <th>Number of RSVP's</th>
    </tr>
    <?php
        $con = new mysqli("localhost", "lovei1_iandbuser", "tfihp2371#3", "lovei1_engageeventmanager");
        if ($con->connect_error) {
            die("Connection failed.");
        }
        $OrgName = $_COOKIE["Organization"];
        $sql = "SELECT * FROM events WHERE `Organization` = '$OrgName'";
        $result = mysqli_query($con,$sql);
        
        if (!$result) {
            echo 'MySQL Error: ' . mysqli_error($con);
            exit;
        }
        
        foreach ($result as $event) { ?>
        <?php #echo $product ?>
        <tr>
        <td><?php echo $event['Name']; ?></td>
        <td><?php echo $event['Description']; ?></td>
        <td><?php echo $event['TimeStart']; ?></td>
        <td><?php echo $event['TimeEnd']; ?></td>
        <td><?php echo $event['Location']; ?></td>
        <td>
            <?php
            $eid = $event['EID'];
            $sql = "SELECT * FROM rsvps WHERE `EID` = '$eid'";
            $result = mysqli_query($con,$sql);
            $count = 0;
            foreach ($result as $rsvps) {
                $count = $count + 1;
            }
            echo $count;
            ?>
        </td>
        <td>
            <form name = "delete" method="post" action="deleteevent.php">
            <input type="hidden" name="eventID" value= "<?php echo $product['EID']; ?>">
            <input type = "submit" value = "Delete">
            </form>
        </td>
        </tr>
    <?php } ?>
    </table>
    <script>
    function searchbar() {
        var search = document.getElementById("search");
        var results = search.value.toUpperCase();
        var table = document.getElementById("table");
        var rows = table.getElementsByTagName("tr");
        var exists;
        var columns;
        for (var i = 1; i < rows.length; i++) {
            columns = rows[i].getElementsByTagName("td");
            for (var j = 0; j < columns.length; j++) {
                if (columns[j].innerHTML.toUpperCase().indexOf(results) >= 0) {
                    exists = true;
                }
            }
            if (exists) {
                rows[i].style.display = "";
                exists = false;
            } else {
                rows[i].style.display = "none";
            }
        }
    }
    </script>
    <footer class="footer">
        <p>&copy; 2025 Software Engineer II Project.</p>
    </footer>
</body>
<?php  #Using https://stackoverflow.com/questions/9127498/how-to-perform-a-real-time-search-and-filter-on-a-html-table ?>
</html>
