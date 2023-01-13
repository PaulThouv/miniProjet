<?php

// -----------------------------------------------Requetes--------------------------------------------------------------------



$qAjouterMatch = 'INSERT INTO unmatch (Nom,Prenom,Numero_Licence,Photo,Date_Naissance,Taille,Poids,Poste_Prefere,Statut,Commentaires) 
VALUES (:nom , :prenom,:numerolicence ,:dateNaissance,:taille,:poids,:posteprefere,:statut, :commentaires)';

// requete pour ajouter un Joueur a la BD
$qAjouterJoueur = 'INSERT INTO joueur(Nom,Prenom,Numero_Licence,Photo,Date_Naissance,Taille,Poids,Poste_Prefere,Statut,Commentaires) 
                    VALUES (:nom , :prenom, :numeroLicence, :photo, :dateNaissance, :taille,:poids,:postePrefere,:statut,:commentaires)';



// requete pour afficher le nom prenom de tous les enfants dont un membre s'occupe (pour le moment ca affiche tout le monde)
$qAfficherNomPrenomJoueur = 'SELECT Id_Joueur, Nom,Prenom FROM Enfant ORDER BY Nom';


// fonction qui permet de se connecter a la BD
function connexionBd()
{
    // parametre de connexion a la BD
    // cDRvPP\2mwea(LGp
    // https://test-saetrisomie21.000webhostapp.com/
    $SERVER = '127.0.0.1';
    $DB = 'equipe_rugby';
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
        // $maxSize = 40000000000000000; && $size <= $maxSize

        if (in_array($extension, $extensions)  && $error == 0) {

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


// -----------------------------------------------Joueur--------------------------------------------------------------------
$qAjouterJoueur = 'INSERT INTO joueur (Nom,Prenom,Numero_Licence,Photo,Date_Naissance,Taille,Poids,Poste_Prefere,Statut,Commentaires) 
                    VALUES (:nom , :prenom,:numerolicence, :photo ,:dateNaissance,:taille,:poids,:posteprefere,:statut, :commentaires)';

// fonction qui permet d'ajouter un enfant a la BD
function ajouterJoueur(
    $Nom,
    $Prenom,
    $Numero_Licence,
    $Photo,
    $Date_Naissance,
    $Taille,
    $Poids,
    $Poste_Prefere,
    $Statut,
    $Commentaires
) {

    // connexion a la BD
    $linkpdo = connexionBd();
    // preparation de la requete sql
    $req = $linkpdo->prepare($GLOBALS['qAjouterJoueur']);
    if ($req == false) {
        die('Erreur ! Il y a un probleme lors de la preparation de la requete pour ajouter un enfant a la BD');
    }
    // execution de la requete sql
    $req->execute(array(
        ':nom' => clean($Nom),
        ':prenom' => clean($Prenom),
        ':numerolicence' => clean($Numero_Licence),
        ':photo' => clean($Photo),
        ':dateNaissance' => clean($Date_Naissance),
        ':taille' => clean($Taille),
        ':poids' => clean($Poids),
        ':posteprefere' => clean($Poste_Prefere),
        ':statut' => clean($Statut),
        ':commentaires' => clean($Commentaires)
    ));
    if ($req == false) {
        die('Erreur ! Il y a un probleme lors l\'execution de la requete pour ajouter un enfant a la BD');
    }
}

// requete pour verifier qu'un enfant avec les données en parametre n'existe pas deja dans la BD
$qJoueurIdentique = 'SELECT Nom, Prenom, Date_Naissance, Numero_Licence FROM joueur 
                    WHERE Nom = :nom AND Prenom = :prenom AND Date_Naissance = :dateNaissance AND Numero_Licence = :numeroLicence';
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
        ':numeroLicence' => clean($numLicence)
    ));
    if ($req == false) {
        die('Erreur ! Il y a un probleme lors l\'execution de la requete pour verifier si un joueur existe deja');
    }
    return $req->rowCount(); // si ligne > 0 alors enfant deja dans la BD
}

$qAfficherJoueur = 'SELECT id_Joueur, Photo, Nom, Prenom, Numero_Licence, Poste_Prefere FROM joueur';
function AfficherJoueur()
{
    // connexion a la BD
    $linkpdo = connexionBd();
    // preparation de la requete sql
    $req = $linkpdo->prepare($GLOBALS['qAfficherJoueur']);
    if ($req == false) {
        die('Erreur ! Il y a un probleme lors de la preparation de la requete pour afficher les information des membres');
    }
    // execution de la requete sql
    $req->execute();
    if ($req == false) {
        die('Erreur ! Il y a un probleme lors de la preparation de la requete pour afficher les information des membres');
    }
    // permet de parcourir toutes les lignes de la requete
    while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
        echo '<tr>';
        // permet de parcourir toutes les colonnes de la requete
        foreach ($data as $key => $value) {
            // selectionne toutes les colonnes $key necessaires
            if ($key == 'Photo') {
                echo '<img class="imageJoueur" src="' . $value . '" alt="">';
                echo ' | ';
            }
            if ($key == 'Nom' || $key == 'Prenom' || $key == 'Numero_Licence' || $key == 'Poste_Prefere') {
                echo '<td>' . $value . ' | ' . '</td>';
            }
            // recuperation valeurs importantes dans des variables
            if ($key == 'id_Joueur') {
                $idJoueur = $value;
            }
        }
        // creation du bouton supprimer dans le tableau
        echo '
            <td>
                <button type="submit" name="boutonSupprimer" class="buttonD" value="' . $idJoueur . '">Supprimer</button>
            </td>
            <td>
                <button type="submit" name="boutonModifier" class="buttonA" value="' . $idJoueur . '">Modifier</button>
            </td>
        </tr><br>';
    }
}

$qSupprimerJoueur = 'DELETE FROM joueur WHERE Id_Joueur = :idJoueur';
// fonction qui permet de supprimer un membre a partir de son idMembre
function supprimerJoueur($idJoueur)
{
    // connexion a la base de donnees
    $linkpdo = connexionBd();
    //on supprime le membre
    $req = $linkpdo->prepare($GLOBALS['qSupprimerJoueur']);
    if ($req == false) {
        die('Erreur ! Il y a un probleme lors de la preparation de la requete pour supprimer un membre de la BD');
    }
    // execution de la requete sql
    $req->execute(array(':idJoueur' => clean($idJoueur)));
    if ($req == false) {
        die('Erreur ! Il y a un probleme lors l\'execution de la requete pour supprimer un membre de la BD');
    }
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
        echo '<table>';
        foreach ($data as $key => $value) {
            // recuperation de toutes les informations du membre de la session dans des inputs 
            if ($key == 'Nom') {
                echo '<tr><td><label for="champNom">Nom :</label>
                <input type="text" name="champNom" placeholder="Entrez le nom" minlength="1" maxlength="50" value="' . $value . '" required>
                <span></span></td>';
            } elseif ($key == 'Prenom') {
                echo '<td><label for="champPrenom">Prénom :</label>
                <input type="text" name="champPrenom" placeholder="Entrez le prénom" minlength="1" maxlength="50" value="' . $value . '"required>
                <span></span></td>';
            } elseif ($key == 'Photo') {
                echo '<td><label for="champPhoto">Photo :</label>
                <input type="file" name="champPhoto" placeholder="Entrez la photo" minlength="1" maxlength="50" value="' . $value . '"required>
                <span></span></td></tr>';
            } elseif ($key == 'Taille') {
                echo '
                <tr><td><label for="champTaille">Taille :</label>
                <input type="text" name="champTaille" placeholder="Entrez la taille" value=' . $value . ' oninput="this.value = this.value.replace(/[^0-9.]/g, \'\').replace(/(\..*)\./g, \'$1\');" maxlength="5" required>
                <span></span></td>';
            } elseif ($key == 'Poids') {
                echo '
                <td><label for="champPoids">Poids :</label>
                <input type="text" name="champPoids" placeholder="Entrez le poids" value=' . $value . ' oninput="this.value = this.value.replace(/[^0-9.]/g, \'\').replace(/(\..*)\./g, \'$1\');" maxlength="5" required>
                <span></span></td>';
            } elseif ($key == 'Poste_Prefere') {
                echo '<td><label for="champPostePrefere"> Poste Préféré :</label>
                <input type="text" name="champPostePrefere" placeholder="Entrez le poste préféré" maxlength="50" value="' . $value . '"  required>
                <span></span></td></tr>';
            } elseif ($key == 'Statut') {
                echo '<tr><td><label for="champStatut"> Statut :</label>
                <input type="text" name="champStatut" placeholder="Entrez le statut" maxlength="50" value="' . $value . '"  required>
                <span></span></td>';
            } elseif ($key == 'Commentaires') {
                echo '<td><label for="champCom"> Commentaires :</label>
                <input type="text" name="champCom" id="champCom" placeholder=" Commentaires " minlength="1" maxlength="250" value="' . $value . '" required>
                <span></span></td></tr>';
            }
        }
    }
    echo '</table>';
}



$qModifierInformationsJoueur = 'UPDATE Joueur SET Nom=:nom, Prenom=:prenom, Photo=:photo,
 Taille=:taille, Poids=:poids,Poste_Prefere=:postePrefere, Statut=:statut,Commentaires=:commentaires WHERE Id_Joueur = :idJoueur';
// fonction qui permet de modifier les informations du membre de la session
function modifierJoueurSession($idJoueur, $nom, $prenom, $photo, $taille, $poids, $postePrefere, $statut, $commentaires)
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
        ':idJoueur' => $idJoueur,
        ':nom' => clean($nom),
        ':prenom' => clean($prenom),
        ':photo' => clean($photo),
        ':taille' => clean($taille),
        ':poids' => clean($poids),
        ':postePrefere' => clean($postePrefere),
        ':statut' => clean($statut),
        ':commentaires' => clean($commentaires)
    ));
    if ($req == false) {
        die('Erreur ! Il y a un probleme lors l\'execution de la requete pour permet de modifier les informations du joueur de la 
            session');
    }
}


//-----------------------------------------LE MATCH-------------------------------------------------------


$qAjouterMatch = 'INSERT INTO unmatch(Date_Heure_Match,Nom_Adversaire,Lieu_Rencontre) 
VALUES (:dateHeureMatch,:nomAdversaire,:lieuRencontre)';
function ajouterMatch($dateHeureMatch, $nomAdversaire, $lieuRencontre)
{
    // connexion a la BD
    $linkpdo = connexionBd();
    // preparation de la requete sql
    $req = $linkpdo->prepare($GLOBALS['qAjouterMatch']);
    if ($req == false) {
        die('Erreur ! Il y a un probleme lors de la preparation de la requete pour ajouter un enfant a la BD');
    }
    // execution de la requete sql
    $req->execute(array(
        ':dateHeureMatch' => clean($dateHeureMatch),
        ':nomAdversaire' => clean($nomAdversaire),
        ':lieuRencontre' => clean($lieuRencontre)
    ));
    if ($req == false) {
        die('Erreur ! Il y a un probleme lors l\'execution de la requete pour ajouter un enfant a la BD');
    }
}
$qAfficherMatchAVenir  = 'SELECT Nom_Adversaire,Lieu_Rencontre,Date_Heure_Match,Id_UnMatch FROM unmatch WHERE Date_Heure_Match > NOW() ORDER BY Date_Heure_Match';
function afficherMatchAVenir(){
     // connexion a la BD
     $linkpdo = connexionBd();
     // preparation de la requete sql
     $req = $linkpdo->prepare($GLOBALS['qAfficherMatchAVenir']);
    if ($req == false) {
        die('Erreur ! Il y a un probleme lors de la preparation de la requete pour afficher les information des membres');
    }
    // execution de la requete sql
    $req->execute();
    if ($req == false) {
        die('Erreur ! Il y a un probleme lors de la preparation de la requete pour afficher les information des membres');
    }
    while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
        // permet de parcourir toutes les colonnes de la requete 
        foreach ($data as $key => $value) {
            // recuperation de toutes les informations du membre de la session dans des inputs 
            if ($key == 'Nom_Adversaire' || $key == 'Lieu_Rencontre' || $key == 'Date_Heure_Match') {
                echo '<td>' . $value . ' | ' . '</td>';
            }
            if ($key == "Id_UnMatch") {
                $idMatch = $value;
            }
        }
        echo '
            <td>
                <button type="submit" name="boutonSupprimer" class="buttonD" value="' . $idMatch . '">Supprimer</button>
            </td>';
        echo '<br>';
}
}
$qSupprimerMatch = 'DELETE FROM unmatch WHERE Id_UnMatch = :idMatch';
function supprimerMatch($idMatch)
{
    // connexion a la base de donnees
    $linkpdo = connexionBd();
    //on supprime le membre
    $req = $linkpdo->prepare($GLOBALS['qSupprimerMatch']);
    if ($req == false) {
        die('Erreur ! Il y a un probleme lors de la preparation de la requete pour supprimer un match de la BD');
    }
    // execution de la requete sql
    $req->execute(array(':idMatch' => clean($idMatch)));
    if ($req == false) {
        die('Erreur ! Il y a un probleme lors l\'execution de la requete pour supprimer un match de la BD');
    }
}