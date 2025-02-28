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
    <title>Contact</title>
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
    </style>
</head>
<body>
    <nav class="navbar">
        <a href="./events.php">Events</a>
        <a href="./calendar.php">Calendar</a>
        <a href="./contact.php">Contact</a>
        <a href="./signout.php">Sign Out</a>
    </nav>

    <header class="hero">
        <h2>Contact</h2>
        <p>You can contact at us on our school email if there is any questions or 
            concerns! Please free to reach out.

            We're thinking of putting a little box where users can input their data and 
            send us any requests/complaints etc

    </header>


    <footer class="footer">
        <p>&copy; 2025 Software Engineer II Project.</p>
    </footer>
</body>
</html>