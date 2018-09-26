<?php
   // connect to mongodb
	$user = "rochelle";
	$pwd = 'Azerty01';
	//$db = 'films-hitema';
	$collection = 'films';
	
	$mongo = new MongoDB\Driver\Manager("mongodb://${user}:${pwd}@ds113923.mlab.com:13923/films-hitema");
	echo "Connection to database successfully";
	
	$filter = [];

	$options = [
		'sort' => ['_id' => -1],
	];

	$query = new MongoDB\Driver\Query($filter, $options);

	$cursor = $mongo->executeQuery('films-hitema.films', $query);
	
	foreach ($cursor as $document) {
		var_dump($document);
	}
	
   // select a database
   //$db = $m->mydb;
	
   //echo "Database mydb selected";
?>