<?php
$mysqli = new mysqli("localhost", "lovei1_iandbuser", "tfihp2371#3", "lovei1_engageeventmanager");
if ($mysqli->connect_error) {
    die("Database connection failed: " . $mysqli->connect_error);
}

$q = isset($_GET['q']) ? trim($_GET['q']) : '';

$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_id'])) {
    $id          = intval($_POST['update_id']);
    $name        = trim($_POST['name']        ?? "");
    $description = trim($_POST['description'] ?? "");
    $email       = trim($_POST['email']       ?? "");
    $password    = trim($_POST['password']    ?? "");

    if ($name === "" || $email === "") {
        $message = "Name and email are required.";
    } else {
        
        $fields = [ "OrgName = ?", "OrgDescription = ?", "OrgEmail = ?" ];
        $types  = "sss";
        $values = [ $name, $description, $email ];

        
        if ($password !== "") {
            $fields[] = "OrgPassword = SHA1(?)";
            $types   .= "s";
            $values[] = $password;
        }

        
        $sql = "UPDATE organizations SET " . implode(", ", $fields) . " WHERE OrgID = ?";
        $types .= "i";
        $values[] = $id;

        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param($types, ...$values);
        if ($stmt->execute()) {
            $message = "Organization updated successfully.";
        } else {
            $message = "Error updating organization: " . $stmt->error;
        }
        $stmt->close();
    }
}

$orgs = [];
if ($q !== '') {
    $stmt = $mysqli->prepare(
        "SELECT OrgID, OrgName, OrgDescription, OrgEmail
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

$edit_org = null;
if (isset($_GET['edit_id'])) {
    $eid = intval($_GET['edit_id']);
    $stmt = $mysqli->prepare(
        "SELECT OrgID, OrgName, OrgDescription, OrgEmail 
         FROM organizations 
         WHERE OrgID = ?"
    );
    $stmt->bind_param("i", $eid);
    $stmt->execute();
    $edit_org = $stmt->get_result()->fetch_assoc() ?: null;
    $stmt->close();
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Update Organization</title>

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
    .message {
      margin: 20px 0;
      padding: 10px;
      background:rgb(166, 207, 173);
      color: black;
      border-radius: 4px;
      text-align: center;
    }

    .search-form {
      margin: 30px 0;
      text-align: center;
    }
    .search-form input {
      width: 60%; max-width: 400px; padding: 8px;
      border: 1px solid #ccc; border-radius: 4px;
    }
    .search-form button {
      padding: 8px 16px; margin-left: 8px;
      background: var(--red); color: var(--white);
      border: none; border-radius: 4px; cursor: pointer;
    }
    .search-form button:hover { background: var(--red-dark); }

    .results .card {
      display: flex; align-items: center;
      background: var(--white); padding: 16px;
      margin-bottom: 16px; border-radius: 8px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }
    .results .card .info {
      flex: 1; text-align: left;
    }
    .results .info h3 { margin:0 0 8px; }
    .results .info p { margin:4px 0; color:rgb(166, 160, 160); }
    .edit-btn {
      background: var(--red); color: var(--white);
      border: none; padding: 8px 12px;
      border-radius: 4px; cursor: pointer;
      transition: background 0.2s;
    }
    .edit-btn:hover { background: var(--red-dark); }


    .update-form {
      margin: 30px auto;
      max-width: 500px;
      text-align: left;
    }
    .update-form label {
      display: block; margin-top: 15px;
      font-weight: bold;
    }
    .update-form input,
    .update-form textarea {
      width: 100%; padding: 8px; margin-top: 6px;
      border: 1px solid #ccc; border-radius: 4px;
      font-family: inherit; font-size: 1rem;
    }
    .update-form textarea { resize: vertical; min-height: 80px; }
    .update-form button {
      margin-top: 20px; background: var(--red);
      color: var(--white); border: none;
      padding: 10px 20px; border-radius: 4px;
      cursor: pointer; transition: background 0.2s;
    }
    .update-form button:hover { background: var(--red-dark) }

    .footer {
      background-color: var(--red);
      color: var(--white);
      padding: 20px;
      text-align: center;
    }
  </style>
</head>

<body>
  <nav class="navbar">
    <a href="homepage.html">Home</a>
    <a href="events.html">Events</a>
    <a href="calendar.html">Calendar</a>
    <a href="About.html">About</a>
    <a href="signout.php">Sign Out</a>
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
        <a href="events.php">View Events</a>
      </div>
    </aside>

    <main class="main-page">
      <h1>Update Organizations</h1>
      <p class="main-page-caption">
        You can search for organizations and update their information
      </p>

      <?php if ($message): ?>
        <div class="message"><?= htmlspecialchars($message) ?></div>
      <?php endif; ?>

      <form class="search-form" method="GET" action="">
        <input
          type="text"
          name="q"
          placeholder="Search organizations…"
          value="<?= htmlspecialchars($q) ?>"
        >
        <button type="submit">Search</button>
      </form>

    
      <?php if (!isset($edit_org)): ?>
        <div class="results">
          <?php if ($q === ""): ?>
            <p style="color:gray;">Enter a name and click Search.</p>
          <?php elseif (empty($orgs)): ?>
            <p style="color:gray;">
              No organizations found for “<?= htmlspecialchars($q) ?>.”
            </p>
          <?php else: ?>
            <?php foreach ($orgs as $o): ?>
              <div class="card">
                <div class="info">
                  <h3><?= htmlspecialchars($o['OrgName']) ?></h3>
                  <p><?= htmlspecialchars($o['OrgDescription']) ?></p>
                  <p><strong>Email:</strong> <?= htmlspecialchars($o['OrgEmail']) ?></p>
                </div>
                <form method="GET" style="margin-left:16px;">
                  <input type="hidden" name="edit_id" value="<?= $o['OrgID'] ?>">
                  <input type="hidden" name="q"       value="<?= htmlspecialchars($q) ?>">
                  <button type="submit" class="edit-btn">Edit</button>
                </form>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>

     
      <?php else: ?>
        <form class="update-form" method="POST" action="">
          <input type="hidden" name="update_id" value="<?= $edit_org['OrgID'] ?>">

          <label for="name">Organization Name</label>
          <input
            type="text"
            id="name"
            name="name"
            required
            value="<?= htmlspecialchars($edit_org['OrgName']) ?>"
          >

          <label for="description">Description</label>
          <textarea
            id="description"
            name="description"
          ><?= htmlspecialchars($edit_org['OrgDescription']) ?></textarea>

          <label for="email">Contact Email</label>
          <input
            type="email"
            id="email"
            name="email"
            required
            value="<?= htmlspecialchars($edit_org['OrgEmail']) ?>"
          >

          <label for="password">
            New Password <small>(leave blank to keep current)</small>
          </label>
          <input
            type="password"
            id="password"
            name="password"
            placeholder="••••••••"
          >

          <button type="submit">Update Organization</button>
        </form>
      <?php endif; ?>
    </main>

  </div>

  <footer class="footer">
    <p>2025 Software Engineer II Project.</p>
</footer>
</body>
</html>
