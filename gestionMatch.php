<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style/style2.css">
  <title>Créer un nouveau match</title>
</head>


<nav>
  <ul>
    <li><a href="ajouterJoueur.php">Joueurs</a></li>
    <li><a href="gestionMatch.php">Match</a></li>
    <li><a href="gererJoueur.php">Gerer Joueur</a></li>
    <li><a href="statistiques.php">Statistiques</a></li>
  </ul>
</nav>
<h1>Création d'un match :</h1>
<?php
require('QUERY.php');
if (champRempli(array('date', 'nomAdv', 'lieuRencontre'))) { {
    ajouterMatch(
      $_POST['date'],
      $_POST['nomAdv'],
      $_POST['lieuRencontre']
    );
  }
}
// }
?>

<body>
  <form action="" method="POST" enctype="multipart/form-data">
    <label for="">DateHeureMatch :</label>
    <input type="datetime-local" name="date" placeholder="Entrez la date" minlength="1" maxlength="50" required>

    <label for="">Nom de l'adversaire :</label>
    <input type="text" name="nomAdv" placeholder="Entrez le nom de l'adversaire" minlength="1" maxlength="50" required>

    <label for="">Lieu de la rencontre :</label>
    <select name="lieuRencontre">
      <option value="Extérieur">Extérieur</option>
      <option value="Domicile">Domicile</option>
    </select>

    <!-- <label for="">Resultat</label> -->
    <!-- <input type="text" name="resultat" id="resultat" placeholder="Une fois le match fait indiquer le resultat"> -->
    <input type="submit">
  </form>
  <form action="" method="POST">
  <h2>Matchs à venir:</h2>
  <?php
  afficherMatchAVenir();
  
  if (isset($_POST['boutonSupprimer'])) {
    supprimerMatch($_POST['boutonSupprimer']);
    header("location: gestionMatch.php");
  }
if(isset($_POST['boutonModifier'])){
  ajouterScore($_POST['boutonModifier'],$_POST['champResultat']);
  header("location: gestionMatch.php");
}

if(isset($_POST['boutonRediriger'])){
  $_SESSION['idMatch'] = $_POST['boutonModifier'];
  header("location: affecterJoueur.php");
}
  ?>
  <h2>Matchs Terminés:</h2>
  <?php
  afficherMatchTermine();
  ?>
  </form>
</body>

</html>