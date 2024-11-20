<?php
// config.php

// Chemin vers votre fichier de base de données SQLite
define('DB_PATH', __DIR__ . '/../db/emploi.db');

function getDbConnection() {
    try {
        $db = new SQLite3(DB_PATH);
        return $db;
    } catch (Exception $e) {
        die("Échec de la connexion à la base de données : " . $e->getMessage());
    }
}
?>