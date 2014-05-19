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
		
	$followingquery = sprintf("SELECT FOLLOWING_USERNAME
							   FROM MT_FOLLOWING WHERE 
							   USERNAME = '$username'");
	$following = mysql_query($followingquery) or die('Failed to search following');
	
	if((mysql_num_rows($following)) > 0) {
		while($usersfollowingresults = mysql_fetch_array($following)) {
			$usersfollowing[] = $usersfollowingresults["FOLLOWING_USERNAME"];
		}
				
		$requiredusers = implode("','",$usersfollowing);
		$findjobquery = sprintf("SELECT ABOUT_USER, COUNT(*) AS OCCURENCES FROM MT_USER 
								 WHERE  USERNAME IN ('$requiredusers')
								 GROUP BY ABOUT_USER
								 ORDER BY OCCURENCES desc LIMIT 1");
		$findjob = mysql_query($findjobquery) or die('Failed to search jobs');
		if((mysql_num_rows($findjob)) == 1) {
			$job = mysql_fetch_row($findjob);
			$requiredjob = $job[0];
		}	
	
		$communityquery = sprintf("SELECT USERNAME 
								   FROM MT_USER
								   WHERE USERNAME IN ('$requiredusers') AND
								   ABOUT_USER = '$requiredjob' ");
		$community = mysql_query($communityquery) or die('Failed to search community');
		if((mysql_num_rows($community)) > 0) {
			while($communityresults = mysql_fetch_array($community)) {
				$communitypeople[] = $communityresults["USERNAME"];
			}
		} 
		
		$breadthfirstpeople = implode("','",$communitypeople);
		$breadthfirstquery = sprintf("SELECT FOLLOWING_USERNAME, COUNT(*) AS OCCURENCES 
									  FROM MT_FOLLOWING
									  WHERE USERNAME IN ('$breadthfirstpeople') AND
									  FOLLOWING_USERNAME != '$username'
									  GROUP BY FOLLOWING_USERNAME
									  ORDER BY OCCURENCES desc");
		$breadthfirst = mysql_query($breadthfirstquery) or die('Failed to find top most occurences');
		if((mysql_num_rows($breadthfirst)) > 0) {
			while($breadthfirstresults = mysql_fetch_array($breadthfirst)) {
				$finalrecommendation[] = $breadthfirstresults["FOLLOWING_USERNAME"];
			}
		}
		
		$index = 1;
		foreach ($finalrecommendation as $recommended) {
			echo "<tr><td><a href='./othersProfile.php?other_user=".$recommended."' class='stylish-button'><font size='4'>$index.$recommended</font></a></td></tr>";
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