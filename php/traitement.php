<?php
// php/traitement.php

// Démarrer la session
session_start();

// Vérifier si config.php existe dans le bon chemin
require_once '../includes/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Détecter quel formulaire a été soumis
    if (isset($_POST['departement']) || isset($_POST['ville']) || isset($_POST['niveau_etude'])) {
        // Traitement du formulaire de recherche
        try {
            $db = new SQLite3('../db/emploi.db');
            
            if (isset($_POST['departement'])) {
                $departement = trim($_POST['departement']);
                // Traitement spécifique pour le département
                // ... votre logique ici
            }
            
            if (isset($_POST['ville'])) {
                $ville = trim($_POST['ville']);
                // Traitement spécifique pour la ville
                // ... votre logique ici
            }
            
            if (isset($_POST['niveau_etude'])) {
                $niveau_etude = trim($_POST['niveau_etude']);
                // Traitement spécifique pour le niveau d'étude
                // ... votre logique ici
            }
            
            header("Location: ../index.php?status=success");
            exit();
            
        } catch (Exception $e) {
            header("Location: ../index.php?status=error&message=" . urlencode($e->getMessage()));
            exit();
        }
    }
    // Traitement du formulaire de contact
    elseif (isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['telephone'])) {
        $nom = trim($_POST['nom']);
        $prenom = trim($_POST['prenom']);
        $telephone = trim($_POST['telephone']);

        // Validation du téléphone
        if (!preg_match("/^[0-9]{2}\.[0-9]{2}\.[0-9]{2}\.[0-9]{2}\.[0-9]{2}$/", $telephone)) {
            header("Location: ../index.php?status=error&message=format_telephone_invalide");
            exit();
        }

        try {
            $db = new SQLite3('../db/emploi.db');
            
            $stmt = $db->prepare('INSERT INTO utilisateurs (nom, prenom, telephone) VALUES (:nom, :prenom, :telephone)');
            
            $stmt->bindValue(':nom', $nom, SQLITE3_TEXT);
            $stmt->bindValue(':prenom', $prenom, SQLITE3_TEXT);
            $stmt->bindValue(':telephone', $telephone, SQLITE3_TEXT);
            
            $result = $stmt->execute();
            
            if ($result) {
                header("Location: ../index.php?status=success");
                exit();
            } else {
                throw new Exception("Erreur lors de l'insertion");
            }
            
        } catch (Exception $e) {
            header("Location: ../index.php?status=error&message=" . urlencode($e->getMessage()));
            exit();
        } finally {
            if (isset($db)) {
                $db->close();
            }
        }
    }
}

// Si on arrive ici, c'est qu'aucun formulaire valide n'a été soumis
header("Location: ../index.php?status=error&message=formulaire_invalide");
exit();
?>