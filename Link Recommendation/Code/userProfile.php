<?php 
session_start();
if(isset($_SESSION['username']) && $_SESSION['username'] != NULL) {
	$username = $_SESSION['username'];
	echo '<div>';
	include("./loginHeader.php");
	echo '</div>';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>User Profile</title>
<link rel="stylesheet" type="text/css" href="/css/searchStyle.css" />
<link rel="stylesheet" type="text/css" href="css/linkStyle.css" />
<script type="text/javascript" src="js/PlaylistValidator.js"></script>
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
?>

<form name="userprofileform" method="post" onsubmit="return userFields()">
	<img src="images/TwitterLogoBird.jpg" height=350 width=100%/>	
	
		<?php 
		$followingCountQuery = "SELECT COUNT(FOLLOWING_USERNAME) AS FOLLOWINGCOUNT FROM MT_FOLLOWING WHERE USERNAME = '$username'";
		$followingCount = mysql_query($followingCountQuery) or die('Failed to count users you follow');
		$followingCountRow = mysql_fetch_assoc($followingCount);
		$noOfFollowing = $followingCountRow['FOLLOWINGCOUNT'];

		$followersCountQuery = "SELECT COUNT(FOLLOWER_USERNAME) AS FOLLOWERSCOUNT FROM MT_FOLLOWERS WHERE USERNAME = '$username'";
		$followersCount = mysql_query($followersCountQuery) or die('Failed to count your followers');
		$followersCountRow = mysql_fetch_assoc($followersCount);
		$noOfFollowers = $followersCountRow['FOLLOWERSCOUNT'];
		
		$userDetailsQuery = "SELECT USER_FIRST_NAME, USER_LAST_NAME, ABOUT_USER FROM MT_USER WHERE USERNAME = '$username'";
		$userDetails = mysql_query($userDetailsQuery) or die('Failed to find user details');
		if((mysql_num_rows($userDetails)) == 1) {
			$userdetailsRow = mysql_fetch_row($userDetails);
			$firstName = $userdetailsRow[0];
			$lastName = $userdetailsRow[1];
			$job = $userdetailsRow[2];
		}
		
		if($job == 1) {
			$userIdentity = "Actor/ Actress/ Producer/ Director";
  		} elseif($job == 2) {
  			$userIdentity = "Activist";
        } elseif($job == 3) {
        	$userIdentity = "Business Analyst/ Consultant";
        } elseif($job == 4) {			
        	$userIdentity = "Critic";
        } elseif($job == 5) {
			$userIdentity = "Engineer/ Developer";
        } elseif($job == 6) {
			$userIdentity = "Politician";
        } elseif($job == 7) {
			$userIdentity = "Professor/ Lecturer/ Education";				
        } elseif($job == 8) {
			$userIdentity = "Student";
        } elseif($job == 9) {
			$userIdentity = "Sports Personality";
        }
	  	
        echo "\n";
        echo '<div class="stylish-name" align="center">'.$firstName. '&nbsp;' .$lastName. '(' .$username. ')&nbsp;-&nbsp;' .$userIdentity. '</div>';
		
		echo '<table align="center" border="1" width=100% height="60">';
		echo '<tr class="stylish-button">';
		echo '<td align = "center">';
		echo '<a href="./searchUsers.php" class="stylish-button">';
		echo "Search Users";
		echo '</a>';
		echo '</td>';
		echo '<td align="center">';
		echo '<a href="./following.php" class="stylish-button">';
		echo $noOfFollowing;
		echo '&nbsp;';
		echo "Following";
		echo '</a>';
		echo '</td>';
		echo '<td align="center">';
		echo '<a href="./followers.php" class="stylish-button">';
		echo $noOfFollowers;
		echo '&nbsp;';
		echo "Followers";
		echo '</a>';
		echo '</td>';
		echo '<td align = "center">';
		echo '<a href="./recommendUsers.php" class="stylish-button">';
		echo "Recommended Users";
		echo '</a>';
		echo '</td>';
		echo '</tr>';
		echo '</table>';
		echo '</br>';
		echo '</br>';
		echo '</br>';
		echo '<div>';
		include("./tweets.php");
		echo '</div>';
		?>
			

</form>

</body>

</html>