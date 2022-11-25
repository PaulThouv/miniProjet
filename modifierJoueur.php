<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
  <meta name="description" content="">
  <title>Modifier objectifs</title>
  <link rel="icon" type="image/x-icon" href="images/favicon.png">
  <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png">
  <link rel="stylesheet" href="style/style.css">
</head>

<body>
  <div class="svgWaveContains">
    <div class="svgWave"></div>
  </div>

  <h1>Modifier les Joueurs</h1>
  <?php
  session_start();
  require('QUERY.php');

  //faireMenu();
  ?>
  <form id="form" method="POST" onsubmit="erasePopup('validationPopup'),erasePopup('erreurPopup')" enctype="multipart/form-data">

    <div class="miseEnForme" id="miseEnFormeFormulaire">
      <?php
        AfficherInformationsJoueurs($_POST['boutonModifier']);
      ?>
    </div>

    <div class="center" id="boutonsValiderAnnuler">
      <button type="submit" formaction="gererObjectifs.php" name="boutonAnnuler" class="boutonAnnuler"><img src="images/annuler.png" class="imageIcone" alt="icone annuler"><span>Annuler</span></button>
      <button type="submit" formaction="gererObjectifs.php?params=modif" value="<?php echo $_POST['boutonModifier']; ?>" name="boutonValider" class="boutonEdit" id="boutonValider"><img src="images/edit.png" class="imageIcone" alt="icone valider"><span>Editer </span></button>
    </div>
    <?php if (isset($_POST['boutonModifier'])) {
      echo $_POST['boutonModifier'];
    } ?>
  </form>
  <script src="js/javascript.js"></script>
</body>

</html>