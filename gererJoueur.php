<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer les joueurs</title>
</head>

<body>
    <form method="POST">
        <?php
        require('QUERY.php');
        AfficherJoueur();
        if (isset($_POST['boutonSupprimer'])) {
            supprimerJoueur($_POST['boutonSupprimer']);
        }
        if (isset($_POST['boutonModifier'])) {
            header("location: modifierJoueur.php");
        }
        ?>
    </form>
</body>

</html>