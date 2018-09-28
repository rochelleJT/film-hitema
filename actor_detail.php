<html>
<head>
<style>
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #dddddd;
}

a {
	color: #000000;
}

h1 {
	text-align: center;
}
</style>
</head>
<body>
<?php
	$actor = $_GET['actor'];
	$user = "rochelle";
	$pwd = 'Azerty01';
	$mongo = new MongoDB\Driver\Manager("mongodb://${user}:${pwd}@ds113923.mlab.com:13923/films-hitema");
	
	
	$filter = ['$or' => [['Actor' => $actor], ['Actress' => $actor]]];
	$options = [
		'sort' => ['Popularity' => -1],
	];

	$query = new MongoDB\Driver\Query($filter, $options);

	$cursor = $mongo->executeQuery('films-hitema.films', $query);
	echo "<h3><a href='actor.php'>Acteurs</a></h3>";
	echo "<br/>";
	echo "<table>";
	echo "<br><br><table><tr><th>Année</th><th>Titre</th><th>Genre</th><th>Directeur</th><th>Popularity</th><th>Awards</th></tr>";
	foreach ($cursor as $document) {
		$document = json_decode(json_encode($document),true);
		echo "<tr><td>${document['Year']}</td>";
		echo "<td>${document['Title']}</td>";
		echo "<td>${document['Subject']}</td>";
		echo "<td>${document['Director']}</td>";
		echo "<td>${document['Popularity']}</td>";
		echo "<td>${document['Awards']}</td></tr>";
	}
	echo "</table>";

?>
</body>
</html>