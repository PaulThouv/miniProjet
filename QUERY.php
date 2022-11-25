<?php


$qAjouterJoueur = 'INSERT INTO joueur (Nom,Prenom,Numero_Licence,Photo,Date_Naissance,Taille,Poids,Poste_Prefere,Statut,Commentaires) 
                    VALUES (:nom , :prenom,:numerolicence ,:dateNaissance,:taille,:poids,:posteprefere,:statut, :commentaires)';

$qAjouterMatch = 'INSERT INTO unmatch (Nom,Prenom,Numero_Licence,Photo,Date_Naissance,Taille,Poids,Poste_Prefere,Statut,Commentaires) 
VALUES (:nom , :prenom,:numerolicence ,:dateNaissance,:taille,:poids,:posteprefere,:statut, :commentaires)';

// requete pour ajouter un Joueur a la BD
$qAjouterJoueur = 'INSERT INTO joueur(Nom,Prenom,Numero_Licence,Photo,Date_Naissance,Taille,Poids,Poste_Prefere,Statut,Commentaires) 
                    VALUES (:nom , :prenom, :numeroLicence, :photo, :dateNaissance, :taille,:poids,:postePrefere,:statut,:commentaires)';

// requete pour verifier qu'un enfant avec les données en parametre n'existe pas deja dans la BD
$qJoueurIdentique = 'SELECT Nom, Prenom, Date_Naissance, Numero_Licence FROM joueur 
                    WHERE Nom = :nom AND Prenom = :prenom AND Date_Naissance = :dateNaissance AND Numero_Licence = :numeroLicence';

// requete pour afficher le nom prenom de tous les enfants dont un membre s'occupe (pour le moment ca affiche tout le monde)
$qAfficherNomPrenomJoueur = 'SELECT Id_Joueur, Nom,Prenom FROM Enfant ORDER BY Nom';

// fonction qui permet de se connecter a la BD
function connexionBd()
{
    // parametre de connexion a la BD
    // cDRvPP\2mwea(LGp
    // https://test-saetrisomie21.000webhostapp.com/
    $SERVER = '127.0.0.1';
    $DB = 'equipe_rubgy';
    $LOGIN = 'root';
    $MDP = '';
    // tentative de connexion a la BD
    try {
        // connexion a la BD
        $linkpdo = new PDO("mysql:host=$SERVER;dbname=$DB", $LOGIN, $MDP);
    } catch (Exception $e) {
        die('Erreur ! Probleme de connexion a la base de donnees' . $e->getMessage());
    }
    return $linkpdo;
}

// fonction qui vérifie que les champs $_POST sont bien remplis
function champRempli($field)
{
    // parcoure la liste des champs 
    foreach ($field as $name) {
        // vérifie s'ils sont vides 
        if (empty($_POST[$name])) {
            return false; // au moins un champs vides
        }
    }
    return true; // champs remplis
}

// fonction qui permet d'enlever les balises de code dans les champs
function clean($champEntrant)
{
    $champEntrant = strip_tags($champEntrant); // permet d'enlever les balises html, xml, php
    $champEntrant = htmlspecialchars($champEntrant); // permet de transformer les balises html en *String
    return $champEntrant;
}

function uploadImage($photo)
{

    if (isset($photo)) {
        $tmpName = $photo['tmp_name'];
        $name = $photo['name'];
        $size = $photo['size'];
        $error = $photo['error'];

        $tabExtension = explode('.', $name);
        $extension = strtolower(end($tabExtension));

        $extensions = ['jpg', 'png', 'jpeg', 'gif', 'svg', 'webp', 'bmp'];
        $maxSize = 400000;

        if (in_array($extension, $extensions) && $size <= $maxSize && $error == 0) {

            $uniqueName = uniqid('', true);
            //uniqid génère quelque chose comme ca : 5f586bf96dcd38.73540086
            $file = $uniqueName . "." . $extension;
            $chemin = "upload/";
            //$file = 5f586bf96dcd38.73540086.jpg
            move_uploaded_file($tmpName, 'upload/' . $file);
            $result = $chemin . $file;
        }
    } else {
        echo '<h1>Erreur ! Problème lors de l\'upload de l\'image</h1>';
    }
    return $result;
}

// -----------------------------------------------Enfant--------------------------------------------------------------------

// fonction qui permet d'ajouter un enfant a la BD
function ajouterEnfant(
    $nom,
    $prenom,
    $dateNaissance,
    $lienJeton
) {

    // connexion a la BD
    $linkpdo = connexionBd();
    // preparation de la requete sql
    $req = $linkpdo->prepare($GLOBALS['qAjouterEnfant']);
    if ($req == false) {
        die('Erreur ! Il y a un probleme lors de la preparation de la requete pour ajouter un enfant a la BD');
    }
    // execution de la requete sql
    $req->execute(array(
        ':nom' => clean($nom),
        ':prenom' => clean($prenom),
        ':dateNaissance' => clean($dateNaissance),
        ':lienJeton' => clean($lienJeton)
    ));
    if ($req == false) {
        die('Erreur ! Il y a un probleme lors l\'execution de la requete pour ajouter un enfant a la BD');
    }
}

function joueurIdentique(
    $nom,
    $prenom,
    $dateNaissance,
    $numLicence
) {
    // connexion a la BD
    $linkpdo = connexionBd();
    // preparation de la requete sql
    $req = $linkpdo->prepare($GLOBALS['qJoueurIdentique']);
    if ($req == false) {
        die('Erreur ! Il y a un probleme lors de la preparation de la requete pour verifier si un joueur existe deja');
    }
    // execution de la requete sql
    $req->execute(array(
        ':nom' => clean($nom),
        ':prenom' => clean($prenom),
        ':dateNaissance' => clean($dateNaissance),
        ':numeroLicence' => clean($numerolicence)
    ));
    if ($req == false) {
        die('Erreur ! Il y a un probleme lors l\'execution de la requete pour verifier si un joueur existe deja');
    }
    return $req->rowCount(); // si ligne > 0 alors enfant deja dans la BD
}
$qRechercherUnJoueur = 'SELECT Nom, Prenom, Numero_Licence,Photo,Date_naissance, Taille, Poids,Poste_Prefere, Statut,Commentaires FROM joueur WHERE Id_Joueur = :id';
function rechercherJoueur($idJoueur)
{
    // connexion a la base de donnees
    $linkpdo = connexionBd();
    // preparation de la requete sql
    $req = $linkpdo->prepare($GLOBALS['qRechercherUnJoueur']);
    if ($req == false) {
        die('Erreur ! Il y a un probleme lors de la preparation de la requete pour rechercher un joueur dans la BD');
    }
    // execution de la requete sql
    $req->execute(array(':id' => clean($idJoueur)));
    if ($req == false) {
        die('Erreur ! Il y a un probleme lors l\'execution de la requete pour rechercher un joueur dans la BD');
    }
    return $req; // retourne le membre correspondant a $idMembre
}


function AfficherInformationsJoueurs($idJoueur)
{
    // recherche les informations d'un membre selon son idMembre
    $req = RechercherJoueur($idJoueur); // retoune le membre avec ses informations selon $idMembre
    // permet de parcourir la ligne de la requetes 
    while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
        // permet de parcourir toutes les colonnes de la requete 
        foreach ($data as $key => $value) {
            // recuperation de toutes les informations du membre de la session dans des inputs 
            if ($key == 'Nom') {
                echo '<label for="champNom">Nom :</label>
                <input type="text" name="champNom" placeholder="Entrez le nom" minlength="1" maxlength="50" value="' . $value . '" required>
                <span></span>';
            } elseif ($key == 'Prenom') {
                echo '<label for="champPrénom">Prénom :</label>
                <input type="text" name="champPrénom" placeholder="Entrez le prénom" minlength="1" maxlength="50" value="' . $value . '"required>
                <span></span>';
            
            } elseif ($key == 'Date_Naissance') {
                echo '<label for="champDateDeNaissance">Date de naissance :</label>
                <input type="date" name="champDateDeNaissance" id="champDateDeNaissance" min="1900-01-01" max="<?php echo date(\'Y-m-d\'); ?>" value="' . $value . '" required>
                <span></span>';
            } elseif ($key == 'Taille') {
                echo '
                <label for="champTaille">Taille :</label>
                <input type="text" name="champTaille" placeholder="Entrez la taille" value=' . $value . ' oninput="this.value = this.value.replace(/[^0-9.]/g, \'\').replace(/(\..*)\./g, \'$1\');" maxlength="5" required>
                <span></span>';
            } elseif ($key == 'Poids') {
                echo '
                <label for="champPoids">Poids :</label>
                <input type="text" name="champPoids" placeholder="Entrez le poids" value=' . $value . ' oninput="this.value = this.value.replace(/[^0-9.]/g, \'\').replace(/(\..*)\./g, \'$1\');" maxlength="5" required>
                <span></span>';
            } elseif ($key == 'PostePrefere') {
                echo '<label for="champPostePrefere"> Poste Préféré :</label>
                <input type="text" name="champPostePrefere" placeholder="Entrez le poste préféré" maxlength="50" value="' . $value . '"  required>
                <span></span>';
            } elseif ($key == 'Statut') {
                echo '<label for="champStatut"> Statut :</label>
                <input type="text" name="champStatut" placeholder="Entrez le statut" maxlength="50" value="' . $value . '"  required>
                <span></span>';
            } elseif ($key == 'Commentaires') {
                echo '<label for="champCom"> Commentaires :</label>
                <input type="text" name="champCom" id="champCom" placeholder=" Commentaires " minlength="1" maxlength="250" value="' . $value . '" required>
                <span></span>';
            }
        }
    }
}



$qModifierInformationsJoueur = 'UPDATE Joueur SET Nom=:nom, Prenom=:prenom,Photo:photo,Date_naissance=:dateNaissance,
 Taille=:taille, Poids=:poids,Poste_Prefere=:postePrefere, Statut=:statut,Commentaires=:commentaires WHERE Id_Joueur = :idJoueur';
// fonction qui permet de modifier les informations du membre de la session
function modifierJoueurSession($idJoueur, $nom, $prenom,$photo,$dateNaissance,$taille,$poids,$postePrefere,$statut,$commentaires)
{
    // connexion a la BD
    $linkpdo = connexionBd();
    // preparation de la requete sql
    $req = $linkpdo->prepare($GLOBALS['qModifierInformationsJoueur']);
    if ($req == false) {
        die('Erreur ! Il y a un probleme lors de la preparation de la requete pour permet de modifier les informations du membre de la 
            session');
    }
    // execution de la requete sql
    $req->execute(array(
        ':nom' => clean($nom),
        ':prenom'=> clean($prenom),
        ':photo'=> clean($photo),
        ':dateNaissance'=> clean($dateNaissance),
        ':taille' => clean($taille),
        ':poids'=> clean($poids),
        ':postePrefere'=> clean($postePrefere), 
        ':statut'=> clean($statut),
        ':commentaires'=> clean($commentaires)
    ));
    if ($req == false) {
        die('Erreur ! Il y a un probleme lors l\'execution de la requete pour permet de modifier les informations du joueur de la 
            session');
    }
}