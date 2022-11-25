<?php

// -----------------------------------------------Requetes--------------------------------------------------------------------



$qAjouterMatch = 'INSERT INTO unmatch (Nom,Prenom,Numero_Licence,Photo,Date_Naissance,Taille,Poids,Poste_Prefere,Statut,Commentaires) 
VALUES (:nom , :prenom,:numerolicence ,:dateNaissance,:taille,:poids,:posteprefere,:statut, :commentaires)';

// requete pour ajouter un Joueur a la BD
$qAjouterJoueur = 'INSERT INTO joueur(Nom,Prenom,Numero_Licence,Photo,Date_Naissance,Taille,Poids,Poste_Prefere,Statut,Commentaires) 
                    VALUES (:nom , :prenom, :numeroLicence, :photo, :dateNaissance, :taille,:poids,:postePrefere,:statut,:commentaires)';

// requete pour verifier qu'un enfant avec les données en parametre n'existe pas deja dans la BD
$qJoueurIdentique = 'SELECT Nom, Prenom, Date_Naissance FROM joueur 
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
