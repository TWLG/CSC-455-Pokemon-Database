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
	
	$query = 'SELECT p1.name, p1.type, p1.atk FROM pokemon p1 JOIN (SELECT type, AVG(atk) AS avg_atk FROM pokemon
  	GROUP BY type
	) p2 ON p1.type = p2.type
	WHERE p1.atk > p2.avg_atk
	ORDER BY p1.type, p1.name';
	
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
	<h2>Pokemon with Higher Than Average ATK</h2>
	<p>"SELECT p1.name, p1.type, p1.atk
FROM pokemon p1
JOIN (
  SELECT type, AVG(atk) AS avg_atk
  FROM pokemon
  GROUP BY type
) p2 ON p1.type = p2.type
WHERE p1.atk > p2.avg_atk
ORDER BY p1.type, p1.name;
"</p>
	<a href="index.html"><button>Back</button></a> 
	<button onClick="window.location.reload();">Refresh Page</button>
	<table>
		<tr>
			<th>name</th>
			<th>type</th>
			<th>atk</th>
	
		</tr>	
		<?php foreach ($all_rows as $client) {
			echo "<tr>";
			echo "<td>".$client['name']."</td>";
			echo "<td>".$client['type']."</td>";
			echo "<td>".$client['atk']."</td>";

			echo "</tr>";
		}
		?>
	</table>
</body>    
</html>
