<?php
$db = new SQLite3('emploi.db');

// Créer la table si elle n'existe pas
$query = "CREATE TABLE IF NOT EXISTS utilisateurs (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nom TEXT NOT NULL,
    prenom TEXT NOT NULL,
    telephone TEXT NOT NULL
)";

$db->exec($query);
echo "Table créée avec succès!";
?>