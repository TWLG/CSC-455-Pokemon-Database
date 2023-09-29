<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

	if(!empty($_GET['name'])) {
		$name = intval($_GET['name']);
		
		require_once('../mysqli_config.php'); //adjust the relative path as necessary to find your config file
		//Retrieve specific vendor data using prepared statements:
		$query = "SELECT DISTINCT $name as playerID, match_count(?) as mcount FROM player_match_history";
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

	<h2>Total Matches</h2>
	<p>"SELECT DISTINCT playerID, match_count(?) FROM player_match_history"</p>
	
	<a href="index.html"><button>Back</button></a> 
	<button onClick="window.location.reload();">Refresh Page</button>
	<a href="player_history.html"><button>Lookup another client</button></a>

	<table>
		<tr>
			<th>Player ID</th>
			<th>Matches</th>
		</tr>	
		<?php foreach ($all_rows as $client) {
			echo "<tr>";

			echo "<td>".$client['playerID']."</td>";
			echo "<td>".$client['mcount']."</td>";
			echo "</tr>";
		}
		?>
	</table>

</body>
</html>