<?php
// Connexion à SQLite
$sqlite = new SQLite3('emploi.db');

// Connexion à MySQL
$mysql = new mysqli('localhost', 'root', '', 'emploi');

if ($mysql->connect_error) {
    die("Erreur de connexion MySQL: " . $mysql->connect_error);
}

// Création des tables MySQL
$mysql->query("
    CREATE TABLE IF NOT EXISTS entreprises (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nom TEXT NOT NULL,
        secteur TEXT NOT NULL
    )
");

$mysql->query("
    CREATE TABLE IF NOT EXISTS offres (
        id INT AUTO_INCREMENT PRIMARY KEY,
        titre TEXT NOT NULL,
        description TEXT NOT NULL,
        entreprise_id INT,
        FOREIGN KEY (entreprise_id) REFERENCES entreprises(id)
    )
");

// Migration des données
$result = $sqlite->query('SELECT * FROM entreprises');
while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
    $stmt = $mysql->prepare("INSERT INTO entreprises (nom, secteur) VALUES (?, ?)");
    $stmt->bind_param("ss", $row['nom'], $row['secteur']);
    $stmt->execute();
}

$result = $sqlite->query('SELECT * FROM offres');
while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
    $stmt = $mysql->prepare("INSERT INTO offres (titre, description, entreprise_id) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $row['titre'], $row['description'], $row['entreprise_id']);
    $stmt->execute();
}

echo "Migration terminée avec succès!";
?>