<?php


$qAjouterJoueur = 'INSERT INTO joueur (Nom,Prenom,Numero_Licence,Photo,Date_Naissance,Taille,Poids,Poste_Prefere,Statut,Commentaires) 
                    VALUES (:nom , :prenom,:numerolicence ,:dateNaissance,:taille,:poids,:posteprefere,:statut, :commentaires)';

$qAjouterMatch = 'INSERT INTO unmatch (Nom,Prenom,Numero_Licence,Photo,Date_Naissance,Taille,Poids,Poste_Prefere,Statut,Commentaires) 
VALUES (:nom , :prenom,:numerolicence ,:dateNaissance,:taille,:poids,:posteprefere,:statut, :commentaires)';

echo("mabite");

// requete pour ajouter un Joueur a la BD
$qAjouterJoueur = 'INSERT INTO joueur(Nom,Prenom,Numero_Licence,Photo,Date_Naissance,Taille,Poids,Poste_Prefere_Statut_Commentaires) 
                    VALUES (:nom , :prenom, :dateNaissance, :lienJeton)';

// requete pour verifier qu'un enfant avec les données en parametre n'existe pas deja dans la BD
$qEnfantIdentique = 'SELECT Nom, Prenom, Date_Naissance FROM enfant 
                    WHERE Nom = :nom AND Prenom = :prenom AND Date_Naissance = :dateNaissance';

// requete pour afficher le nom prenom de tous les enfants dont un membre s'occupe (pour le moment ca affiche tout le monde)
$qAfficherNomPrenomEnfant = 'SELECT Id_Enfant, Nom,Prenom FROM Enfant ORDER BY Nom';

?>