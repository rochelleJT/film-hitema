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
	$user = "rochelle";
	$pwd = 'Azerty01';
	$mongo = new MongoDB\Driver\Manager("mongodb://${user}:${pwd}@ds113923.mlab.com:13923/films-hitema");

	$cmd_actor = new \MongoDB\Driver\Command([
    'aggregate' => 'films',
    'pipeline' => [['$group' => ['_id' => '$Actor', 'count' => ['$sum' => 1]]] ],
	'cursor' => new stdClass
	]);
	$cursor_actor = $mongo->executeCommand('films-hitema',  $cmd_actor);
	
	echo "<h3><a href='index.php'>Accueil</a></h3>";
	echo "<table><tr><th>Acteur/Actrice</th><th>Nombre de films</th></tr>";
	foreach ($cursor_actor as $document) {
		$document = json_decode(json_encode($document),true);
		$actor = $document['_id'];
		echo "<tr><td><a href='actor_detail.php?actor=${actor}'>${actor}</a></td>";
		echo "<td>${document['count']}</td></tr>";
	}
	
	$cmd_actress = new \MongoDB\Driver\Command([
    'aggregate' => 'films',
    'pipeline' => [['$group' => ['_id' => '$Actress', 'count' => ['$sum' => 1]]] ],
	'cursor' => new stdClass
	]);
	
	$cursor_actress = $mongo->executeCommand('films-hitema',  $cmd_actress);
	foreach ($cursor_actress as $document2) {
		$document2 = json_decode(json_encode($document2),true);
		$actress = $document2['_id'];
		echo "<tr><td><a href='actor_detail.php?actor=${actress}'>${actress}</a></td>";
		echo "<td>${document2['count']}</td></tr>";
	}
	echo "</table>";	
?>
</body>
</html>