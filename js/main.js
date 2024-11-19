<?php
// Configuration de la base de données
define('DB_FILE', __DIR__ . '/../emploi.db');

// Fonction de connexion à la base de données
function getDBConnection() {
    try {
        $db = new SQLite3(DB_FILE);
        return $db;
    } catch (Exception $e) {
        die("Erreur de connexion : " . $e->getMessage());
    }
}

// Fonction pour valider le numéro de téléphone
function validatePhone($phone) {
    return preg_match('/^[0-9]{2}\.[0-9]{2}\.[0-9]{2}\.[0-9]{2}\.[0-9]{2}$/', $phone);
}

// Fonction pour nettoyer les entrées
function cleanInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>