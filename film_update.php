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

	if(isset($_GET['modifier']))
	{    
	    $id = $_GET['id'];
	    $film = array (
	                'annee'     => $_GET['annee'],
	                'titre'     => $_GET['titre'],
	                'genre'     => $_GET['genre'],
	                'acteurs'   => $_GET['acteurs'],
	                'actrices'  => $_GET['actrices'],
	                'directeur' => $_GET['directeur']
	            );
	    $bulk = new MongoDB\Driver\BulkWrite;
		$bulk->update(
		    ['_id' => new MongoDB\BSON\ObjectID($id)],
		    ['$set' => ['Year'     => $film['annee'], 
		    			'Title'    => $film['titre'],
		    			'Subject'  => $film['genre'],
		    			'Actor'    => $film['acteurs'],
		    			'Actress'  => $film['actrices'],
		    			'Director' => $film['directeur']]]
		);

$result = $mongo->executeBulkWrite('films-hitema.films', $bulk);
	} // end if $_POST

	//getting id from url
	$id = $_GET['id'];
	 
	//selecting data associated with this particular id
	$filter = ['_id' => new MongoDB\BSON\ObjectID($id)];

	$options = [];
	$query = new MongoDB\Driver\Query($filter, $options);
	$cursor = $mongo->executeQuery('films-hitema.films', $query);


	foreach ($cursor as $document) {
		$document = json_decode(json_encode($document),true);

		$id = implode(" ",$document['_id']);
		$annee     = $document['Year'];
	    $titre     = $document['Title'];
	    $genre     = $document['Subject'];
	    $acteurs   = $document['Actor'];
	    $actrices  = $document['Actress'];
	    $directeur = $document['Director'];

	    echo "
	    	<a href='index.php'>Accueil</a>
	    	<br/><br/>
	    
		    <form name='form1' method='get' action='film_update.php'>
		        <table border='0'>
		            <tr> 
		                <td>Année</td>
		                <td><input type='text' name='annee' value=".$annee."></td>
		            </tr>
		            <tr> 
		                <td>Titre</td>
		                <td><input type='text' name='titre' value=".$titre."></td>
		            </tr>
		            <tr> 
		                <td>Genre</td>
		                <td><input type='text' name='genre' value=".$genre."></td>
		            </tr>
		            <tr> 
		                <td>Acteurs</td>
		                <td><input type='text' name='acteurs' value=".$acteurs."></td>
		            </tr>
		            <tr> 
		                <td>Actrices</td>
		                <td><input type='text' name='actrices' value=".$actrices."></td>
		            </tr>
		            <tr> 
		                <td>Directeur</td>
		                <td><input type='text' name='directeur' value=".$directeur."></td>
		            </tr>

		            <tr>
		                <td><input type='hidden' name='id' value=".$id."></td>
		                <td><input type='submit' name='modifier' value='MODIFIER'></td>
		            </tr>
		        </table>
		    </form>";
	}
?>
</body>
</html>