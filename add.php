<html>
<head>
    <title>Ajouter un film</title>
</head>
 
<body>
<?php
    $user = "rochelle";
    $pwd = 'Azerty01';
    $mongo = new MongoDB\Driver\Manager("mongodb://${user}:${pwd}@ds113923.mlab.com:13923/films-hitema");
 
    if(isset($_GET['ajouter'])) {    
        $film = array (
            'Year'       => $_GET['Year'],
            'Title'      => $_GET['Title'],
            'Length'     => $_GET['Length'],
            'Subject'    => $_GET['Subject'],
            'Actor'      => $_GET['Actor'],
            'Actress'    => $_GET['Actress'],
            'Director'   => $_GET['Director'],
            'Popularity' => $_GET['Popularity'],
            'Awards'     => $_GET['Award'],
            'Image'      => $_GET['Image']
        );

        $bulk = new MongoDB\Driver\BulkWrite;

        $filmToAddData = [
            '_id'           => new MongoDB\BSON\ObjectId(),
            'Year'          => $film['Year'],
            'Title'         => $film['Title'],
            'Length'        => $film['Length'],
            'Subject'       => $film['Subject'],
            'Actor'         => $film['Actor'],
            'Actress'       => $film['Actress'],
            'Director'      => $film['Director'],
            'Popularity'    => $film['Popularity'],
            'Awards'        => $film['Awards'],
            'Image'         => $film['Image'],

        ];

        $bulk->insert($filmToAddData);

        $result = $mongo->executeBulkWrite('films-hitema.films', $bulk);
        header("Location:index.php");
    }
?>

<a href="index.php">Accueil</a>
    <br/><br/>
 
    <form action="add.php" method="get" name="form2">
        <table width="25%" border="0">
            <tr> 
                <td>Année</td>
                <td><input type="number" name="Year" required=""></td>
            </tr>
            <tr> 
                <td>Titre</td>
                <td><input type="text" name="Title" required=""></td>
            </tr>
            <tr> 
                <td>Durée</td>
                <td><input type="number" name="Length" required=""></td>
            </tr>
            <tr> 
                <td>Genre</td>
                <td><input type="text" name="Subject" required=""></td>
            </tr>
            <tr> 
                <td>Acteur</td>
                <td><input type="text" name="Actor" required=""></td>
            </tr>
            <tr> 
                <td>Actrice</td>
                <td><input type="text" name="Actress" required=""></td>
            </tr>
            <tr> 
                <td>Directeur</td>
                <td><input type="text" name="Director" required=""></td>
            </tr>
            <tr> 
                <td>Popularité</td>
                <td><input type="text" name="Popularity" required=""></td>
            </tr>
            <tr> 
                <td>Award</td>
                <td><input type="text" name="Award" required=""></td>
            </tr>
            <tr> 
                <td>Image</td>
                <td><input type="File" name="Image"></td>
            </tr>
            <tr> 
                <td></td>
                <td><input type="submit" name="ajouter" value="Ajouter" required=""></td>
            </tr>
        </table>
    </form>
</body>
</html>