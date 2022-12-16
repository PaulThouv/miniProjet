<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta name="description" content="">
    <title>Connexion</title>
    <link rel="icon" type="image/x-icon" href="images/favicon.png">
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png">
    <link rel="stylesheet" href="style/style.css">
</head>

<body>
    <div class="svgWaveContains">
        <div class="svgWave"></div>
    </div>
    <div class="test"></div>
    <img src="images/logo.png" alt="logo application" class="iconeApp">

    <form id="formConnexion" action="indexConnexion.php" method="POST">
        <div class="miseEnForme" id="miseEnFormeConnexion">
            <label for="champIdentifiant">Identifiant :</label>
            <input type="text" name="champIdentifiant" id="champIdentifiant" placeholder="Entrez votre identifiant" minlength="1" maxlength="50" required>
            <span></span>

            <label for="champMotDePasse">Mot de passe :</label>
            <input type="password" name="champMotDePasse" id="champMotDePasse" placeholder="Mot de passe (4 charactères minimum)" minlength="4" maxlength="50" required>
            <span></span>

        </div>

        <button type="submit" name="boutonConnexion" class="boutons" id="boutonConnexion"><img src="images/unlock.png" class="imageIcone" alt="icone cadenas"><span>Connexion</span></button>
    </form>
</body>

</html>
<?php
session_start();
require('QUERY.php');
$linkpdo = connexionBd();
if (!empty($_POST['champIdentifiant']) && !empty($_POST['champMotDePasse'])) // Si il existe les champs email, password et qu'il sont pas vides
{
    $courriel = $_POST['champIdentifiant'];
    $mdp = $_POST['champMotDePasse'];
    $courriel = strtolower($courriel);
    $courriel = clean($courriel);
    $mdp = clean($mdp);



    // Si le mdp est bon (pas sécurisé faudra mettre un hash après)
    if ($mdp === 'test' && $courriel === 'test') {
        header('Location: ajouterJoueur.php');
        $_SESSION['idConnexion'] = 'Brice_Arnault_est_né_le_23_novembre';
        die();
    } else {
        header('Location: index.php?login_err=invalide');
        die();
    }
}
