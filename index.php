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
</style>
</head>
<body>
<?php
	$user = "rochelle";
	$pwd = 'Azerty01';
	$mongo = new MongoDB\Driver\Manager("mongodb://${user}:${pwd}@ds113923.mlab.com:13923/films-hitema");
	
	$filter = ['Year' => ['$gt' => 1900]];

	$options = [
		'sort' => ['_id' => -1],
	];

	$query = new MongoDB\Driver\Query($filter, $options);

	$cursor = $mongo->executeQuery('films-hitema.films', $query);
	
	echo "<br><br><table><tr><th>Année</th><th>Titre</th><th>Genre</th><th>Acteurs</th><th>Actrices</th><th>Directeur</th></tr>";
	foreach ($cursor as $document) {
		$document = json_decode(json_encode($document),true);
		echo "<tr>";
		echo "<td>" . $document['Year']. "</td><td><a href='film_detail.php?_id=".implode(" ",$document['_id'])."'>" . $document['Title']. "</a></td><td>". $document['Subject']. "</td><td>". $document['Actor']. "</td><td>". $document['Actress']. "</td><td>". $document['Director']. "</td>";
		echo "</tr>";
	}
	echo "</table>";
?>
</body>
</html>