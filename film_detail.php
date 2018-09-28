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
	$id = $_GET['_id'];
	$user = "rochelle";
	$pwd = 'Azerty01';
	$mongo = new MongoDB\Driver\Manager("mongodb://${user}:${pwd}@ds113923.mlab.com:13923/films-hitema");
	
	$filter = ['_id' => new MongoDB\BSON\ObjectID($id)];
	$options = [];

	$query = new MongoDB\Driver\Query($filter, $options);

	$cursor = $mongo->executeQuery('films-hitema.films', $query);
	
	foreach ($cursor as $document) {
		$document = json_decode(json_encode($document),true);
		echo "<h1><a href='index.php'>Home</a></h1>";
		echo "<br/><br/>";
		echo "<table>";
		echo "<tr><th>Année</th><td>"      . $document['Year']. "</td></tr>";
		echo "<tr><th>Durée</th><td>"      . $document['Length']. "</td></tr>";
		echo "<tr><th>Titre</th><td>"      . $document['Title']. "</td></tr>";
		echo "<tr><th>Genre</th><td>"      . $document['Subject']. "</td></tr>";
		echo "<tr><th>Acteurs</th><td>"    . $document['Actor']. "</td></tr>";
		echo "<tr><th>Director</th><td>"   . $document['Director']. "</td></tr>";
		echo "<tr><th>Popularité</th><td>" . $document['Popularity']. "</td></tr>";
		echo "<tr><th>Award</th><td>"	   . $document['Awards']. "</td></tr>";
		echo "</table>";
	}
	

?>
</body>
</html>