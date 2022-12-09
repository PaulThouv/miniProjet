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
      AfficherInformationsJoueurs(7);
      ?>
    </div>

    <div class="center" id="boutonsValiderAnnuler">
      <button type="submit" name="boutonAnnuler" class="boutonAnnuler"><img src="images/annuler.png" class="imageIcone" alt="icone annuler"><span>Annuler</span></button>
      <button type="submit" value="" name="boutonValider" class="boutonEdit" id="boutonValider"><img src="images/edit.png" class="imageIcone" alt="icone valider"><span>Editer </span></button>
    </div>

    <?php if (isset($_POST['boutonValider'])) {
      modifierJoueurSession(
        7,
        $_POST['champNom'],
        $_POST['champPrenom'],
        $_POST['champPhoto'],
        $_POST['champTaille'],
        $_POST['champPoids'],
        $_POST['champPostePrefere'],
        $_POST['champStatut'],
        $_POST['champCom']
      );
      header("location: modifierJoueur.php");
    } ?>
  </form>
  <script src="js/javascript.js"></script>
</body>

</html>