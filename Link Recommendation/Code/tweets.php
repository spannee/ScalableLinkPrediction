<?php 
if(isset($_SESSION['username']) && $_SESSION['username'] != NULL) {
	$username = $_SESSION['username'];
}
?>

<!DOCTYPE html PUBLIC -//W3C//DTD XHTML 1.0 Transitional//EN http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd>
<html xmlns=http://www.w3.org/1999/xhtml>

<head>
<meta http-equiv=Content-Type content=text/html charset=UTF-8 />
<title>Tweets</title>
<link rel="stylesheet" type="text/css" href="/css/linkStyle.css" />
<link rel="stylesheet" type="text/css" href="css/linkStyle.css" />
<style type="text/css">
	.center {
    	position:fixed;
        top:40%;
        left:35%; 
    }

</style>
</head>

<body>
<form name="tweets" method="post">

<table>
<tr><td align = "center"> 
<textarea name="tweet" rows="3" cols="163" id="tweet" class="stylish-border"></textarea> 
</td></tr>
<tr>		
<td align = "right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<input type="submit" name="posttweet" value="Tweet" class="stylish-button" style="background-color:#4099FF; color: #ffffff;"/>
</td> 
</tr>
</table>

<br>
<br>
<br>
<br>
<br>

<table align="right" border="1" width=70%  height="500">

<?php 
if(isset($_POST['index'])) {
	$indexvalue = $_POST['index'];
	$startindex = ($indexvalue * 10) - 10;
	$tweetquery = sprintf("SELECT * FROM MT_TWEETS WHERE
						   USERNAME = '$username' LIMIT $startindex,10 ");
} else {
	$tweetcountquery = sprintf("SELECT COUNT(USERNAME) FROM MT_TWEETS WHERE USERNAME = '$username' ");
	$tweetcount = mysql_query($tweetcountquery) or die('Failed to check count');
	$maxtweetcount = mysql_fetch_row($tweetcount);
	if($maxtweetcount[0] != 0) {
		$required = $maxtweetcount[0] % 10;
		if($required == 0) {
			$shown = 10;
		} else {
			$shown = $required;
		}
	} else {
		$shown = 10;
	}
	
	$tweetquery = sprintf("SELECT * FROM (SELECT * FROM MT_TWEETS WHERE
 						   USERNAME = '$username' ORDER BY TWEET_TIME DESC
     					   LIMIT $shown) AS LAST_TWEET ORDER BY TWEET_TIME");	
} 

if(isset($tweetquery)) {	
    $tweetrequired = mysql_query($tweetquery) or die('Failed to retrieve tweets');
	if(mysql_num_rows($tweetrequired) > 0) {
		while($tweetresult = mysql_fetch_array($tweetrequired)) {
			$tweettabelid = $tweetresult["TWEET_ID"];
			$tweetsequenceno = $tweetresult["TWEET_SEQ_NO"];
			$tweet = $tweetresult["TWEET_DATA"];
			echo '<tr class="stylish-button">';
			echo '<td>';
			echo $tweet;
			echo '</td>';
			echo '</tr>';
		}
	}
}

?>
</table>
	
<?php 
if(isset($_POST['posttweet'])) {
	
		$tweet = $_POST['tweet'];
		
		if($tweet != NULL) {
			$tweetsequencequery = sprintf("SELECT MAX(TWEET_SEQ_NO) FROM MT_TWEETS WHERE
									 	   USERNAME = '$username'");
		
			$tweetsequence = mysql_query($tweetsequencequery) or die('Failed to check sequence number');
			$maxtweetsequence = mysql_fetch_row($tweetsequence);
			if($maxtweetsequence[0] != NULL) {
				$sequencenumber = $maxtweetsequence[0] + 1;				
			} else {
				$sequencenumber = 1;
			}
			
			$tweetindexquery = sprintf("SELECT TWEET_INDEX FROM MT_TWEETS WHERE
										USERNAME = '$username' ORDER BY TWEET_TIME DESC LIMIT 1");
			
			$tweetindex = mysql_query($tweetindexquery) or die('Failed to check index number');
			$maxtweetindex = mysql_fetch_row($tweetindex);
			if($maxtweetindex[0] == NULL) {
				$indexnumber = 1;
			} elseif($maxtweetindex[0] < 5) {
				$indexnumber = $maxtweetindex[0] + 1;
			} elseif($maxtweetindex[0] == 5) {
				$indexnumber = 1;
			}
			
			$addtweetquery = "INSERT INTO MT_TWEETS(TWEET_SEQ_NO, USERNAME, TWEET_DATA, TWEET_INDEX, TWEET_TIME)
							  VALUES('$sequencenumber', '$username', '$tweet', '$indexnumber', NOW())";
			$addtweet = mysql_query($addtweetquery) or die("Failed to tweet");
			$tweetid = mysql_insert_id();
			if(isset($tweetid)) {
				print '<META HTTP-EQUIV="refresh" CONTENT="15">';
			}
		} else {
			echo '<script type="text/javascript">';
			echo 'alert("Please tweet something")';
			echo '</script>';
		}
} 

?>
<table>
	<?php 
	$tweetsequencequery = sprintf("SELECT MAX(TWEET_SEQ_NO) FROM mt_tweets WHERE
								   USERNAME = '$username'");
	
	$tweetsequence = mysql_query($tweetsequencequery) or die('Failed to check sequence number');
	$maxtweetsequence = mysql_fetch_row($tweetsequence);
	
	if($maxtweetsequence[0] != NULL) {
		$extra = $maxtweetsequence % 10; 
	}
	
	if($maxtweetsequence[0] != NULL && $maxtweetsequence[0] <= 10) {
		
	} elseif($maxtweetsequence[0] != NULL && $maxtweetsequence[0] > 10){
		$extra = $maxtweetsequence % 10;
		
		$numbersrequired = intval($maxtweetsequence[0] / 10);
		if($extra > 0) {
			$numbersrequired = $numbersrequired + 1;
		}
		echo '<tr>';
		echo '<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		for($i=1;$i<=$numbersrequired;$i++) {
			echo '<input type="submit" name="index" value="';
			echo $i;
			echo '" style="width: 20px;"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'; 
		}
		echo '</td>';
		echo '</tr>';
	}
	?>
</table>

</form>
</body>
</html>
