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
<form name="searchUserForm" method="post">
<br/>
<table align="center">
	<tr>
		<td> <input type="text" size="60" class="inputtext" maxlength="300" name="usertag" id="usertag"/></td>
		<td> <input type="submit" name="searchuserbutton" value="Search Users" class="stylish-button" style="background-color:#4099FF; color: #ffffff;"/> </td>		
	</tr>	
	
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
	
	if(isset($_POST['searchuserbutton'])) {
		$usertag = $_POST['usertag'];
	
		$userssearchquery = sprintf("SELECT USERNAME
									 FROM MT_USER WHERE 
									 USERNAME = '$usertag' AND
									 USERNAME != '$username'");
		$userssearch = mysql_query($userssearchquery) or die('Failed to search users');
	
		if((mysql_num_rows($userssearch)) == 1) {
			echo "<tr><td><a href='./othersProfile.php?other_user=".$usertag."' class='stylish-button'><font size='4'>$usertag</font></a></td></tr>";	
		} else {
			echo '<script type="text/javascript">';
			echo 'alert("No users found")';
			echo '</script>';
		}
	}
	
	?>
</table>
</form>