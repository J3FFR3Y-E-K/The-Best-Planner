# The-Best-Planner
Engage Imported Event Manager/Planner. Student and organization driven; allows for reliable event searching; allows for calender customization;  
2/24 Norke: Added all initial website files, including image file for logo

2/27 Ian: Changed all website files to php (originals are being kept as baseline) and added login and signup pages. Also implemented login system using php pages and a database. All websites are now live through https://cyan.csam.montclair.edu/~lovei1/ and no page besides login and signup are available to those who aren't logged in. Along with this I uploaded to the GitHub a txt document with the SQL code of the users database with 2 users already in it


3/2 Cristian: Stress tested https://cyan.csam.montclair.edu/~lovei1/ to check how many users it would take for the system to crash. During the stress test it was found that the system can perfectly handle under 400 users. After the 400 threshold the system begins to have issues. 10,000 user loads were tested but the system started failing after 2,000 users. Jmeter was used.


3/2 Jeffrey: Penetration tested the login page, https://cyan.csam.montclair.edu/~lovei1/. Tested using brute force hacking and basic SQL injections. Brute force hacking was done using Burp Suite whcih was set up so that it would flag once a viable password was entered out of a list of 1000 common passwords. An account could be accessed using brute force hacking which can be protected using password requirements like a minimum password length or mandatory special characters in a future update. The basic SQL injections could not hack into a login page but there is potential for a more thorough SQL injection to do so.
