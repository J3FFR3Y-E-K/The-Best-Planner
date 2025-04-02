<?php
    setcookie("Organization", "Players", time() + (1800), "/");
    
        /*(!isset($_COOKIE["Organization"])) {
             header("Location: https://cyan.csam.montclair.edu/~lovei1/login.html");
             die();
        }*/


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events Addition</title>
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
        
        .form-object {
           	display: flex;
            	flex-direction: column;
            	gap: 5px;
        }
        .form-input {
        	display: flex;
       		align-items: center;
          	gap: 5px;
        }
       	label {
           	width: 150px;
       	}
		
	    input {
		    width:300px;
		    height:30px;
	    }
	
    </style>
</head>
<body>
    <nav class="navbar">
        <a href="./orghomepage.php">Home</a>
        <a href="./orgevents.php">Events</a>
        <a href="./orginfo.php">Org Info</a>
        <a href="./signout.php">Sign Out</a>
    </nav>

    <header class="hero">
        <h2>Events Addition</h2>
        
        <div class="form-object">
		    <form name = "loginForm" method="post" action="eventadd.php">
			    <p>
    				<div class="form-input">
    					<label>Event Name: </label>         
    					<input name = "name" type = "text" size = "50" maxlength = "50" required>
    				</div>
    				<br>
    				<div class="form-input">
						<label>Description:</label>
						<textarea name="description" rows="4" cols="50" required></textarea>
					</div>
                    <br>
    				<div class="form-input">
    					<label>Start-Time: </label>         
    					<input name = "start" type = "datetime-local" size = "50" required>
    				</div>
    				<br>
    				<div class="form-input">
    					<label>End-Time: </label>         
    					<input name = "end" type = "datetime-local" size = "50" required>
    				</div>
    				<br>
    				<input type = "submit" value = "Submit" style="width:100; height:20;">
    				<input type = "reset" value = "Clear" style="width:100; height:20;">
        	    </p>
	        </form>
	    </div>
    </header>


    <footer class="footer">
        <p>&copy; 2025 Software Engineer II Project.</p>
    </footer>
</body>
</html>
