<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

	if(!empty($_GET['name'])) {
		$name = $_GET['name'];
		
		require_once('../mysqli_config.php'); //adjust the relative path as necessary to find your config file
		//Retrieve specific vendor data using prepared statements:
		$query = "SELECT p.name, b.battleID, b.gymID, b.result as match_result FROM player p join player_match_history pmh on p.playerID = pmh.playerID join battles b on b.battleID = pmh.battleID where p.name Like CONCAT('%', ?, '%')";
		$stmt = mysqli_prepare($dbc, $query);
		mysqli_stmt_bind_param($stmt, "s", $name);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt); 
		$rows = mysqli_num_rows($result);

		if($rows > 0) {
		$all_rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
	} else {
		echo "<h2>No matching players found</h2>";
		mysqli_close($dbc);
		exit;
	}	}
	else {
		echo "You have reached this page in error";
		exit;
	}
	//Clients found, output results
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Pokemon</title>
	<meta charset ="utf-8"> 
	<!-- Add some spacing to each table cell -->
	<style> td, th {padding: 1em;} </style>
</head>
<body>

	<h2>Player List</h2>
	<p>"SELECT p.name, b.battleID, b.gymID, b.result as match_result FROM player p join player_match_history pmh on p.playerID = pmh.playerID join battles b on b.battleID = pmh.battleID where p.name Like CONCAT('%', ?, '%')"</p>
	
	<a href="index.html"><button>Back</button></a> 
	<button onClick="window.location.reload();">Refresh Page</button>
	<a href="player_history.html"><button>Lookup another client</button></a>

	<table>
		<tr>
			<th>Player Name</th>
			<th>BattleID</th>
			<th>GymID</th>
			<th>Match Result</th>
		</tr>	
		<?php foreach ($all_rows as $client) {
			echo "<tr>";
			echo "<td>".$client['name']."</td>";
			echo "<td>".$client['battleID']."</td>";
			echo "<td>".$client['gymID']."</td>";
			echo "<td>".$client['match_result']."</td>";
			echo "</tr>";
		}
		?>
	</table>

</body>
</html>