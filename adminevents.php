<?php
        if(!isset($_COOKIE["Admin"])) {
                header("Location: https://cyan.csam.montclair.edu/~lovei1/login.html");
                die();
            }
?>

<?php
$mysqli = new mysqli("localhost", "lovei1_iandbuser", "tfihp2371#3", "lovei1_engageeventmanager");
if ($mysqli->connect_error) {
    die("Database connection failed: " . $mysqli->connect_error);
}

$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $stmt = $mysqli->prepare("DELETE FROM organizations WHERE OrgID = ?");
    $stmt->bind_param("i", $_POST['delete_id']);
    if ($stmt->execute()) {
        $nameDelete = $_POST['name'];
        $stmt = $mysqli->prepare("DELETE FROM events WHERE `Organization` = '$nameDelete'");
        $stmt->execute();
        $message = "Organization deleted successfully.";
    } else {
        $message = "Error deleting organization.";
    }
    $stmt->close();
}


$q = isset($_GET['q']) ? trim($_GET['q']) : '';


$orgs = [];
if ($q !== '') {
    $stmt = $mysqli->prepare(
        "SELECT OrgID, OrgName, OrgDescription
         FROM organizations 
         WHERE OrgName LIKE ?"
    );
    $like = "%{$q}%";
    $stmt->bind_param("s", $like);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($row = $res->fetch_assoc()) {
        $orgs[] = $row;
    }
    $stmt->close();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Delete Organization</title>

  <style>
    :root {
      --red:       #E01822;
      --red-dark:  #B91C1C;
      --white:     #FFFFFF;
      --gray-light: #F3F4F6;
      --gray-mid:  #E5E7EB;
      --gray-dark: #4B5563;
    }

    * {
      box-sizing: border-box;
    }
    body {
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
      background-color: var(--gray-light);
      color: var(--gray-dark);
      text-align: center;
    }
    a {
      text-decoration: none;
    }

    .navbar {
      background-color: var(--red);
      padding: 15px 0;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .navbar a {
      color: var(--white);
      font-weight: bold;
      margin: 0 15px;
      transition: color 0.2s;
    }
    .navbar a:hover {
      color: var(--gray-mid);
    }

    .container-1 {
      display: flex;
      min-height: 100vh;
    }

    .side-bar {
      width: 30%;
      background-color: var(--white);
      box-shadow: 2px 0 5px rgba(0,0,0,0.05);
    }
    .title {
      background-color: var(--red);
      padding: 30px 10px;
      border-top-right-radius: 8px;
    }
    .title p {
      margin: 0;
      font-size: 1.25rem;
      color: var(--white);
      font-weight: bold;
    }
    .options {
      background-color: var(--gray-mid);
      margin: 20px;
      padding: 15px;
      border-radius: 8px;
      text-align: left;
    }
    .options .caption {
      font-size: 1.1rem;
      color: var(--red-dark);
      border-bottom: 2px solid var(--red-dark);
      padding-bottom: 8px;
      margin-bottom: 12px;
    }
    .options a {
      display: block;
      color: var(--gray-dark);
      font-size: 1rem;
      padding: 8px 0;
      transition: color 0.2s;
    }
    .options a:hover {
      color: var(--red);
    }

    .main-page {
      width: 70%;
      background-color: var(--white);
      padding: 60px 40px;
      box-shadow: -2px 0 5px rgba(0,0,0,0.05);
    }
    .main-page h1 {
      margin-top: 0;
      font-size: 2rem;
      color: var(--gray-dark);
    }
    .main-page-caption {
      font-size: 1.1rem;
      color: var(--gray-dark);
      margin-top: 12px;
    }

    .footer {
      background-color: var(--red);
      color: var(--white);
      padding: 20px;
      text-align: center;
    }
    .search-form {
      margin: 30px 0;
      text-align: center;
    }
    .search-form input {
      width: 60%;
      max-width: 400px;
      padding: 8px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }
    .search-form button {
      padding: 8px 16px;
      margin-left: 8px;
      background: var(--red);
      color: var(--white);
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
    .search-form button:hover { background: var(--red-dark); }

   
    .results .card {
      display: flex;
      align-items: flex-start;
      background: var(--white);
      padding: 16px;
      margin-bottom: 16px;
      border-radius: 8px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
      text-align: center;
    }

    .results .card .info {
      flex: 1;
      text-align: left;
    }
    .results .card .info h3{
      margin: 4px 0;
    }
    .results .card .info p{
        margin: 4px 0;
        word-break: break-word;
    }
    .results .card .info {
        flex: 1;
        text-align: center;
    }

    .delete-btn {
      background: var(--red);
      color: var(--white);
      border: none;
      padding: 8px 12px;
      border-radius: 4px;
      cursor: pointer;
      transition: background 0.2s;
    }
    .delete-btn:hover { background: var(--red-dark); }
    
    table {
          size: 50%;
          margin-left: auto;
          margin-right: auto;
          border-collapse: collapse;
          border-spacing: 5px;
        }

        th, td {
          border: 1px solid black;
          padding: 10px;
        }
  </style>
</head>

<body>
    <nav class="navbar">
        <a href="./signout.php">Sign Out</a>
    </nav>
  <div class="container-1">
    <aside class="side-bar">
      <div class="title">
        <p>Admin Page</p>
      </div>
      <div class="options">
        <p class="caption">Admin Options</p>
        <a href="ViewOrganizations.php">View Organizations</a>
        <a href="AddOrganizations.php">Add Organizations</a>
        <a href="DeleteOrganizations.php">Delete Organizations</a>
        <a href="UpdateOrganizations.php">Update Organizations</a>
        <a href="adminevents.php">View Events</a>
      </div>
    </aside>

    <main class="main-page">
      <h1>View Events</h1>
    <header class="hero">
        <h2>Events</h2>
    </header>
    <br>
    <input type="text" id="search" placeholder="Search for events" size=70 onkeyup='searchbar()'>
    <br>
    <br>
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
        
        $sql = "SELECT * FROM events";
        $result = mysqli_query($con,$sql);
        
        if (!$result) {
            echo 'MySQL Error: ' . mysqli_error($con);
            exit;
        }
        
        foreach ($result as $product) { ?>
        <?php #echo $product ?>
        <tr>
        <td><?php echo $product['Name']; ?></td>
        <td><?php echo $product['Organization']; ?></td>
        <td><?php echo $product['Description']; ?></td>
        <td><?php echo $product['TimeStart']; ?></td>
        <td><?php echo $product['TimeEnd']; ?></td>
        <td><?php echo $product['Location']; ?></td>
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
    </main>
  </div>

  <footer class="footer">
    <p>2025 Software Engineer II Project.</p>
</footer>
</body>
</html>
