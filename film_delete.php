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

<title>Modifier film</title>
</head>
<body>
<?php
	$user = "rochelle";
	$pwd = 'Azerty01';
	$mongo = new MongoDB\Driver\Manager("mongodb://${user}:${pwd}@ds113923.mlab.com:13923/films-hitema");
    $id = $_GET['id'];

    $bulk = new MongoDB\Driver\BulkWrite;
	$bulk->delete(
		['_id' => new MongoDB\BSON\ObjectID($id)],
		['limit' => 1]
	);
		$result = $mongo->executeBulkWrite('films-hitema.films', $bulk);
		header("Location:index.php");
?>
</body>
</html>