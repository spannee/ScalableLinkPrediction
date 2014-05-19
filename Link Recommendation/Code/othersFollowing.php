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

if(isset($_SESSION['otheruser']) && $_SESSION['otheruser'] != NULL) {
	$otherusername = $_SESSION['otheruser'];
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
		
	$followingquery = sprintf("SELECT FOLLOWING_USERNAME
							   FROM MT_FOLLOWING WHERE 
							   USERNAME = '$otherusername'");
	$following = mysql_query($followingquery) or die('Failed to search following');
	
	if((mysql_num_rows($following)) > 0) {
		$users = array();
		while($usersfollowingresults = mysql_fetch_array($following)) {
			$usersfollowing[] = $usersfollowingresults["FOLLOWING_USERNAME"];
		}
		$index = 1;
		foreach ($usersfollowing as $user) {
			if($user == $username) {
				echo "<tr><td><a href='./userProfile.php' class='stylish-button'><font size='4'>$index.$user</font></a></td></tr>";
			} else {
				echo "<tr><td><a href='./othersProfile.php?other_user=".$user."' class='stylish-button'><font size='4'>$index.$user</font></a></td></tr>";
			}
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