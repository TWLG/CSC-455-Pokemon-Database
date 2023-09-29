<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	require_once('../mysqli_config.php'); //Connect to the database
	
	if (!$dbc) {
		echo "<h2>We are unable to process this request right now.</h2>"; 
		echo "<h3>Please try again later.</h3>";
		exit;
	} 
	
	$query = 'SELECT player.name Winners, COUNT(battles.result) NumWins FROM player JOIN player_match_history JOIN battles WHERE player.playerID=player_match_history.playerID AND player_match_history.battleID=battles.battleID GROUP BY player.name, battles.result HAVING battles.result="win"';
	
	$result = mysqli_query($dbc, $query);
	
	if($result) {
		$all_rows= mysqli_fetch_all($result, MYSQLI_ASSOC); //get the result as an associative, 2-dimensional array
	} else { 
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
	<h2>Player Wins</h2>
	<p>"SELECT player.name Winners, COUNT(battles.result) NumWins FROM player JOIN player_match_history JOIN battles WHERE player.playerID=player_match_history.playerID AND player_match_history.battleID=battles.battleID GROUP BY player.name, battles.result HAVING battles.result="win""</p>
	<a href="index.html"><button>Back</button></a> 
	<button onClick="window.location.reload();">Refresh Page</button>
	<table>
		<tr>
			<th>Winners</th>
			<th>NumWins </th>
	
		</tr>	
		<?php foreach ($all_rows as $client) {
			echo "<tr>";
			echo "<td>".$client['Winners']."</td>";
			echo "<td>".$client['NumWins']."</td>";

			echo "</tr>";
		}
		?>
	</table>
</body>    
</html>
