<?php
require_once '../includes/config.php';
// ... reste de votre code traitement.php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validation côté serveur
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $telephone = trim($_POST['telephone']);

    // Vérification du format du téléphone
    if (!preg_match("/^[0-9]{2}\.[0-9]{2}\.[0-9]{2}\.[0-9]{2}\.[0-9]{2}$/", $telephone)) {
        die("Format de téléphone invalide");
    }

    try {
        $db = new SQLite3('emploi.db');
        
        $stmt = $db->prepare('INSERT INTO utilisateurs (nom, prenom, telephone) VALUES (:nom, :prenom, :telephone)');
        
        $stmt->bindValue(':nom', $nom, SQLITE3_TEXT);
        $stmt->bindValue(':prenom', $prenom, SQLITE3_TEXT);
        $stmt->bindValue(':telephone', $telephone, SQLITE3_TEXT);
        
        $result = $stmt->execute();
        
        if ($result) {
            header("Location: index.html?status=success");
            exit();
        } else {
            header("Location: index.html?status=error");
            exit();
        }
        
    } catch (Exception $e) {
        header("Location: index.html?status=error");
        exit();
    } finally {
        $db->close();
    }
}
?>