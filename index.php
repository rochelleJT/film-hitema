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
	
	$filter = [];
	$title='';
	$year=0;
	$subject='';
	$actor='';
	$actress='';
	$director='';
	
	if(isset($_GET['SubmitButton'])){
		$title = $_GET['title'];
		$year = $_GET['year'];
		$subject = $_GET['subject'];
		$actor = $_GET['actor'];
		$actress = $_GET['actress'];
		$director = $_GET['director'];
	}
	
	if ($title!=null) $filter ['Title'] = new MongoDB\BSON\Regex(trim($title, '/'), 'i');
	if ($year!=0) $filter['Year'] = (int)$year;
	if ($subject!=null && $subject!='Genre') $filter['Subject'] = $subject;
	if ($actor!=null) $filter['Actor'] = new MongoDB\BSON\Regex(trim($actor, '/'), 'i');
	if ($actress!=null) $filter['Actress'] = new MongoDB\BSON\Regex(trim($actress, '/'), 'i');
	if ($director!=null) $filter['Director'] = new MongoDB\BSON\Regex(trim($director, '/'), 'i');
	
	
	$options = [
		'sort' => ['_id' => -1],
	];

	$query = new MongoDB\Driver\Query($filter, $options);
	$cursor = $mongo->executeQuery('films-hitema.films', $query);
	
	$cmd = new MongoDB\Driver\Command(['distinct' => 'films', 'key' => 'Subject']);
	$cursor2 = $mongo->executeCommand('films-hitema', $cmd);
	$subjects = current($cursor2->toArray())->values;
	
	echo "<form name='search' action='' method='get'>
		<input type='text' name='title' id='title' placeholder='Titre...'>
		<input type='number' name='year' id='year' placeholder='Année...'>
		<select name='subject'>
			<option>Genre</option>";
		foreach ($subjects as $sub){
			echo "<option value=".$sub.">".$sub."</option>";
		}
	echo "</select>
		<input type='text' name='actor' id='actor' placeholder='Acteur...'>
		<input type='text' name='actress' id='actress' placeholder='Actrice...'>
		<input type='text' name='director' id='director' placeholder='Directeur...'>
		<input type='submit' name='SubmitButton'/>
		</form>";
	
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