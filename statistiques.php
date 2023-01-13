<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style2.css">
    <title>Ajouter un joueur</title>
</head>

<nav>
    <ul>
        <li><a href="ajouterJoueur.php">Joueurs</a></li>
        <li><a href="gestionMatch.php">Match</a></li>
        <li><a href="gererJoueur.php">Gerer Joueur</a></li>
        <li><a href="statistiques.php">Statistiques</a></li>
    </ul>
</nav>
<h1>Statistiques :</h1>

<body>
    <table>
        <tr>
            <td>
                <label for="">Matchs gagnés :</label>
                <input type="text" name="gagne" disabled>
            </td>
        </tr>
        <tr>
            <td>
                <label for="">Matchs perdus :</label>
                <input type="text" name="perdu" disabled>
            </td>
        </tr>
        <tr>
            <td>
                <label for="">Matchs nuls :</label>
                <input type="text" name="nul" disabled>
            </td>
        </tr>
    </table>
</body>

</html>