<?php
	ini_set ('error_reporting', 1); //Turns on error reporting - remove once everything works.
	require_once('../mysqli_config.php'); //Connect to the database
	$query = 'SELECT leaderName, badgeName
FROM gymLeader JOIN gymLeaderBadges JOIN gym
WHERE gymLeader.leaderID=gym.leaderID AND gymLeaderBadges.badgeId = gym.badge';
	$result = mysqli_query($dbc, $query);
	//Fetch all rows of result as an associative array
	if($result)
		$all_rows= mysqli_fetch_all($result, MYSQLI_ASSOC); //get the result as an associative, 2-dimensional array
	else { 
		echo "<h2>We are unable to process this request right now.</h2>"; 
		echo "<h3>Please try again later.</h3>";
		exit;
	} 
	mysqli_close($dbc);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<!-- LIAM COYLE -->
    <title>Pokemon</title>
	<meta charset ="utf-8"> 
</head>
<body>
	<h2>Player List</h2>
	<p>'SELECT leaderName, badgeName
FROM gymLeader JOIN gymLeaderBadges JOIN gym
WHERE gymLeader.leaderID=gym.leaderID AND gymLeaderBadges.badgeId = gym.badge';
</p>
	<a href="index.html"><button>Back</button></a> 
	<button onClick="window.location.reload();">Refresh Page</button>
	<table>
		<tr>
			<th>Leader Name</th>
			<th>Badge</th>
		</tr>	
		<?php foreach ($all_rows as $client) {
			echo "<tr>";
			echo "<td>".$client['leaderName']."</td>";
			echo "<td>".$client['badgeName']."</td>";
			echo "</tr>";
		}
		?>
	</table>
</body>    
</html>


