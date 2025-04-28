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
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $name        = trim($_POST['name'] ?? "");
    $description = trim($_POST['description'] ?? "");
    $email       = trim($_POST['email'] ?? "");
    $password    = trim($_POST['password'] ?? "");

    if ($name === "" || $email === "" || $password === "") {
        $message = "Name, email and password are required.";
    } else {
        
        $stmt = $mysqli->prepare(
            "INSERT INTO organizations (OrgName, OrgDescription, OrgEmail, OrgPassword)
             VALUES (?, ?, ?, SHA1(?))"
        );
        $stmt->bind_param("ssss", $name, $description, $email, $password);
        if ($stmt->execute()) {
            $message = "Organization added successfully.";
        } else {
            $message = "Error adding organization: " . $stmt->error;
        }
        $stmt->close();
    }
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Organization</title>

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
      padding: 12px;
      background:rgb(187, 226, 201);
      color: black;
      border-radius: 4px;
      text-align: center;
    }

    /* add form */
    .add-form {
      margin: 30px auto;
      max-width: 500px;
      text-align: left;
    }
    .add-form label {
      display: block;
      margin-top: 15px;
      font-weight: bold;
    }
    .add-form input,
    .add-form textarea {
      width: 100%;
      padding: 8px;
      margin-top: 6px;
      border: 1px solid #ccc;
      border-radius: 4px;
      font-size: 1rem;
      font-family: inherit;
    }
    .add-form textarea {
      resize: vertical;
      min-height: 80px;
    }
    .add-form button {
      margin-top: 20px;
      background: var(--red);
      color: var(--white);
      border: none;
      padding: 10px 20px;
      border-radius: 4px;
      cursor: pointer;
      font-size: 1rem;
      transition: background 0.2s;
    }
    .add-form button:hover { background: var(--red-dark); }

    .footer {
      background-color: var(--red);
      color: var(--white);
      padding: 20px;
      text-align: center;
    }

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
      <h1>Add Organizations</h1>
      <p class="main-page-caption">
        Make sure you add the Organization name, email address, and password. Also add a description for the Organization
      </p>
      <p class="main-page-caption">
        Please add the following here:
      </p>

      <?php if ($message): ?>
        <div class="message"><?= htmlspecialchars($message) ?></div>
      <?php endif; ?>

      <form class="add-form" method="POST" action="">
        <label for="name">Organization Name</label>
        <input type="text" id="name" name="name" required>

        <label for="description">Description</label>
        <textarea id="description" name="description"></textarea>

        <label for="email">Contact Email</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Add Organization</button>
      </form>

      
      
    </main>
  </div>

  <footer class="footer">
    <p>2025 Software Engineer II Project.</p>
</footer>
</body>
</html>
