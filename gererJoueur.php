<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style/style2.css">
  <title>Gérer les joueurs</title>
</head>

<nav>
  <ul>
    <li><a href="ajouterJoueur.php">Joueurs</a></li>
    <li><a href="gestionMatch.php">Match</a></li>
    <li><a href="gererJoueur.php">Gerer Joueur</a></li>
  </ul>
</nav>

<body>
  <form method="POST">
    <?php
    require('QUERY.php');
    AfficherJoueur();
    if (isset($_POST['boutonSupprimer'])) {
      supprimerJoueur($_POST['boutonSupprimer']);
      header("location: gererJoueur.php");
    }
    if (isset($_POST['boutonModifier'])) {
      header('location: modifierJoueur.php?id=' . $_POST['boutonModifier']);
    }
    ?>
  </form>
</body>

</html>