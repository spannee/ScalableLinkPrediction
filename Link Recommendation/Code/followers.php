<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Search User</title>
<link rel="stylesheet" type="text/css" href="/css/searchStyle.css" />
<link rel="stylesheet" type="text/css" href="css/linkStyle.css" />
</head>

<body>
<?php 

$dbconnection = "connection.php";

if(file_exists($dbconnection)) {
	include $dbconnection;
} else if(file_exists("../".$dbconnection)) {
	include "../".$dbconnection;
} else {
	include "../../".$dbconnection;
}

dbConnect();

session_start();
if(isset($_SESSION['username']) && $_SESSION['username'] != NULL) {
	$username = $_SESSION['username'];
	echo '<div>';
	include("./loginHeader.php");
	echo '</div>';
} else {
	print "<meta http-equiv='refresh' content='0;url=index.php'>";
}
?>
<form name="followingForm" method="post">
<br/>
<table align="center">
	
	<?php 
	echo '<tr></tr>';
	echo '<tr></tr>';
	echo '<tr></tr>';
	echo '<tr></tr>';
	echo '<tr></tr>';
	echo '<tr></tr>';
	echo '<tr></tr>';
	echo '<tr></tr>';
	echo '<tr></tr>';
	echo '<tr></tr>';
	echo '<tr></tr>';
	echo '<tr></tr>';
	echo '<tr></tr>';
	echo '<tr></tr>';
	echo '<tr></tr>';
	echo '<tr></tr>';
	echo '<tr></tr>';
	echo '<tr></tr>';
	echo '<tr></tr>';
	echo '<tr></tr>';
		
	$followerquery = sprintf("SELECT FOLLOWER_USERNAME
							   FROM MT_FOLLOWERS WHERE 
							   USERNAME = '$username'");
	$follower = mysql_query($followerquery) or die('Failed to search followers');
	
	if((mysql_num_rows($follower)) > 0) {
		$users = array();
		while($usersfollowerresults = mysql_fetch_array($follower)) {
			$usersfollower[] = $usersfollowerresults["FOLLOWER_USERNAME"];
		}
		$index = 1;
		foreach ($usersfollower as $user) {
			echo "<tr><td><a href='./othersProfile.php?other_user=".$user."' class='stylish-button'><font size='4'>$index.$user</font></a></td></tr>";
			echo '<br>';
			$index++;
		}			
	} else {
		echo '<script type="text/javascript">';
		echo 'alert("No users found")';
		echo '</script>';
	}
	
	?>
</table>
</form>