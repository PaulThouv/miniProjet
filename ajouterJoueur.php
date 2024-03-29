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
<h1>Ajouter un joueur :</h1>

<?php
require('QUERY.php');
if (champRempli(array('nom', 'prenom', 'numeroLicence', 'dateNaissance', 'taille', 'poids', 'poste', 'statut', 'commentaire'))) {
    if (joueurIdentique(
        $_POST['nom'],
        $_POST['prenom'],
        $_POST['dateNaissance'],
        $_POST['numeroLicence']
    ) == 0) {
        ajouterJoueur(
            $_POST['nom'],
            $_POST['prenom'],
            $_POST['numeroLicence'],
            uploadImage($_FILES['photo']),
            $_POST['dateNaissance'],
            $_POST['taille'],
            $_POST['poids'],
            $_POST['poste'],
            $_POST['statut'],
            $_POST['commentaire']
        );
    }
}
// }
?>

<body>
    <form action="" method="POST" enctype="multipart/form-data">
        <table>
            <tr>
                <td>
                    <label for="">Nom :</label>
                    <input type="text" name="nom" placeholder="Entrez le nom" minlength="1" maxlength="50" required>
                </td>
                <td>
                    <label for="">Prénom :</label>
                    <input type="text" name="prenom" placeholder="Entrez le prénom" minlength="1" maxlength="50" required>
                </td>
                <td>
                    <label for="">Numéro de licence :</label>
                    <input type="text" name="numeroLicence" placeholder="Entrez le numéro de licence" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" maxlength="5" required>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="">Photo :</label>
                    <input type="file" name="photo" id="photo" accept="image/png, image/jpeg, image/svg+xml, image/webp, image/bmp" onchange="refreshImageSelector('champImageJeton','imageJeton')" required>
                </td>
                <td>
                    <label for="">Date de naissance :</label>
                    <input type="date" name="dateNaissance" id="champDateDeNaissance" min="1900-01-01" max="<?php echo date('Y-m-d'); ?>" required>
                </td>
                <td>
                    <label for="">Taille :</label>
                    <input type="text" name="taille" placeholder="Entrez la taille" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" maxlength="5" required>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="">Poids :</label>
                    <input type="text" name="poids" placeholder="Entrez le poids" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" maxlength="5" required>
                </td>
                <td>
                    <label for="">Poste préféré :</label>
                    <input type="text" name="poste" placeholder="Entrez le poste préféré" minlength="1" maxlength="50" required>
                </td>
                <td>
                    <label for="">Statut</label>
                    <select name="statut" id="">
                        <option value="1">Actif</option>
                        <option value="2">Blessé</option>
                        <option value="3">Suspendu</option>
                        <option value="4">Absent</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="">Commentaire :</label>
                    <input type="text" name="commentaire" placeholder="Entrez un commentaire" minlength="1" maxlength="250" required>
                </td>
            </tr>
        </table>
        <input type="submit" class="buttonA" value="Ajouter">
    </form>

</body>

</html>