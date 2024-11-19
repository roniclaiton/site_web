<?php
// Chemin vers la base de données
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
?>