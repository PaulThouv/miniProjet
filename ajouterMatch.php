<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un nouveau match</title>
</head>

<?php
require('QUERY.php');
if (champRempli(array('date', 'NomAdv', 'lieuRencontre'))) {
    {
        ajouterMatch(
            $_POST['date'],
            $_POST['nomAdv'],
            $_POST['lieuRencontre'],
            $_POST['resultat']
        );
    }
}
// }
?>

<body>
    <form action="" method="POST" enctype="multipart/form-data">
        <label for="">DateHeureMatch :</label>
        <input type="date" name="date" placeholder="Entrez la date" minlength="1" maxlength="50" required>

        <label for="">Nom de l'adversaire :</label>
        <input type="text" name="NomAdv" placeholder="Entrez le nom de l'adversaire" minlength="1" maxlength="50" required>

        <label for="">Lieu de la rencontre :</label>
        <input type="text" name="lieuRencontre" placeholder="Indiquer le lieu de la rencontre"   minlength="1" maxlength="55" required>

        <label for="">resultat</label>
        <input type="text" name="resultat" id="resultat" placeholder="Une fois le match fait indiquer le resultat">

    </form>

</body>

</html>