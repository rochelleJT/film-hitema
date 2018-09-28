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
    text-align: center;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #dddddd;
}

a {
	color: #000000;
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
	$year_min='';
	$year_max='';
	$subject='';
	$actor='';
	$actress='';
	$director='';
	
	if(isset($_GET['SubmitButton'])){
		$title = $_GET['title'];
		$year_min = $_GET['yearMin'];
		$year_max = $_GET['yearMax'];
		$subject = $_GET['subject'];
		$actor = $_GET['actor'];
		$actress = $_GET['actress'];
		$director = $_GET['director'];
	}
	
	if(isset($_GET['EraseButton'])){
		$title='';
		$year_min='';
		$year_max='';
		$subject='';
		$actor='';
		$actress='';
		$director='';
	}
	
	if($year_min!=null && $year_max!=null) $filter = ['Year'=>['$gte'=>(int)$year_min, '$lte'=>(int)$year_max]];
	elseif ($year_min!=null && $year_max==null) $filter = ['Year'=>['$gte'=>(int)$year_min]];
	elseif ($year_min==null && $year_max!=null) $filter = ['Year'=>['$lte'=>(int)$year_max]];
	if ($title!=null) $filter ['Title'] = new MongoDB\BSON\Regex(trim($title, '/'), 'i');
	if ($subject!=null && $subject!='Genre...') $filter['Subject'] = $subject;
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
	
	echo "<h3><a href='actor.php'>Acteurs</a></h3>";
	echo "<form name='search' action='' method='get'>
		<input type='text' name='title' id='title' placeholder='Titre...' value='".$title."'>
		<input type='number' name='yearMin' id='yearMin' placeholder='Année min...'value='".$year_min."'>
		<input type='number' name='yearMax' id='yearMax' placeholder='Année max...'value='".$year_max."'>
		<select name='subject' value='".$subject."'>
			<option>Genre...</option>";
		foreach ($subjects as $sub){
			if ($sub != null) echo "<option value=".$sub.">".$sub."</option>";
		}
	echo "</select>
		<input type='text' name='actor' id='actor' placeholder='Acteur...' value='".$actor."'>
		<input type='text' name='actress' id='actress' placeholder='Actrice...' value='".$actress."'>
		<input type='text' name='director' id='director' placeholder='Directeur...' value='".$director."'>
		<input type='submit' name='SubmitButton'/>
		</form>";
	echo "<form name='search' action='' method='get'>
		<input type='submit' value='Effacer les filtres' name='EraseButton'/>
		</form>";
	
	echo "<br><br><table><tr><th>Année</th><th>Titre</th><th>Genre</th><th>Acteurs</th><th>Actrices</th><th>Directeur</th><th>Update</th></tr>";
	foreach ($cursor as $document) {
		$document = json_decode(json_encode($document),true);
		echo "<tr>";
		echo "<td>"
			.$document['Year']
			."</td><td><a href='film_detail.php?_id="
			.implode(" ",$document['_id'])
			."'>"
			.$document['Title']
			."</a></td><td>"
			.$document['Subject']
			."</td><td>"
			.$document['Actor']
			."</td><td>"
			.$document['Actress']
			."</td><td>"
			.$document['Director']
			."</td><td><a href='film_update.php?id=".implode(" ",$document['_id'])
			."'>Modifier</a> | <a href='film_delete.php?id=".implode(" ",$document['_id'])
			."' onClick=\"return confirm('Etes vous sûr de vouloir supprimer ce film?')\">Supprimer</a></td>"
			."</td>";
		echo "</tr>";
	}
	echo "</table>";
?>
</body>
</html>