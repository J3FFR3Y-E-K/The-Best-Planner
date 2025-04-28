<?php
        if(!isset($_COOKIE["Login"])) {
             header("Location: https://cyan.csam.montclair.edu/~lovei1/login.html");
             die();
        }

$con = new mysqli("localhost", "lovei1_iandbuser", "tfihp2371#3", "lovei1_engageeventmanager");
if ($con->connect_error) {
    die("Connection failed.");
}

$name = urlencode($_POST['name']);
$description = urlencode($_POST['desc']);

$startTime = $_POST['ts'];
$dateTimeS = new DateTime($startTime);
$newFormatS = $dateTimeS->format('Ymd\\THi00\\Z+UTCTIME');

$endTime = $_POST['te'];
$dateTimeE = new DateTime($endTime);
$newFormatE = $dateTimeE->format('Ymd\\THi00\\Z+UTCTIME');

$start = urlencode($newFormatS);
$end = urlencode($newFormatE);

$location = urlencode($_POST['loc']);

$googleCalendarUrl = "https://www.google.com/calendar/render?action=TEMPLATE&text=$name&details=$description&location=$location&dates=$start/$end";

header("Location: $googleCalendarUrl");
exit();

?>
