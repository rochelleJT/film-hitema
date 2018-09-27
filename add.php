<html>
<head>
    <title>Ajouter un film</title>
</head>
 
<body>
<?php
    $user = "rochelle";
    $pwd = 'Azerty01';
    $mongo = new MongoDB\Driver\Manager("mongodb://${user}:${pwd}@ds113923.mlab.com:13923/films-hitema");
 
if(isset($_GET['Submit'])) {    
    $data = array (
        'Year'       => $_GET['Year'],
        'Title'      => $_GET['Title'],
        'Subject'    => $_GET['Subject'],
        'Actor'      => $_GET['Actor'],
        'Actress'    => $_GET['Actress'],
        'Director'   => $_GET['Director'],
        'Popularity' => $_GET['Popularity'],
        'Awards'     => $_GET['Awards'],
        'Image'      => $_GET['Image']
    );
$bulk = new MongoDB\Driver\BulkWrite;

$film_1 = [
    'Year'          => $_GET['Year'],
    'Title'         => $_GET['Title'],
    'Subject'       => $_GET['Subject'],
    'Actor'         => $_GET['Actor'],
    'Actress'       => $_GET['Actress'],
    'Director'      => $_GET['Director'],
    'Popularity'    => $_GET['Popularity'],
    'Awards'        => $_GET['Awards'],
    'Image'         => $_GET['Image'],

];
$film_2 = ['' => 'custom ID', 'title' => 'two'
];
$film_3 = ['_id' => new MongoDB\BSON\ObjectId, 'title' => 'three'];

$_id1 = $bulk->insert($film1);
$_id2 = $bulk->insert($film2);
$_id3 = $bulk->insert($film3);

var_dump($_id1, $_id2, $_id3);
$result = $manager->executeBulkWrite('db.collection', $bulk);


        //display success message
        echo "<font color='green'>Data added successfully.";
        echo "<br/><a href='index.php'>View Result</a>";
}

echo "<br/><a href='index.php'>View Result</a>";


?>
</body>
</html>