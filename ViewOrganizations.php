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

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>View Organizations</title>

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
    .search-form button:hover {
      background: var(--red-dark);
    }

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
      <h1>View Organizations Page</h1>
      <p class="main-page-caption">
        You can Search here to view the current organizations present
      </p>

      <form class="search-form" method="GET" action="">
        <input
          type="text"
          name="q"
          placeholder="Search organizations…"
          value="<?= htmlspecialchars($q) ?>"
        >
        <button type="submit">Search</button>
      </form>

      <div class="results">
        <?php if ($q === ''): ?>
          <p style="gray; text-align:center;">
            Enter a name above and click Search.
          </p>

        <?php elseif (empty($orgs)): ?>
          <p style="color:gray; text-align:center;">
            No organizations found for “<?= htmlspecialchars($q) ?>.”
          </p>

        <?php else: ?>
          <?php foreach ($orgs as $o): ?>
            <div class="card">
    
              <div class="info">
                <h3><?= htmlspecialchars($o['OrgName']) ?></h3>
                <p><?= htmlspecialchars($o['OrgDescription']) ?></p>
              </div>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
    </main>
  </div>

  <footer class="footer">
    <p>2025 Software Engineer II Project.</p>
</footer>
</body>
</html>
