<?php
try {
    $db = new PDO('sqlite:../db/database.sqlite');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $departement = $_POST['departement'];
    $stmt = $db->prepare('SELECT * FROM ville WHERE code_departement = ? ORDER BY nom_ville');
    $stmt->execute([$departement]);
    $villes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    header('Content-Type: application/json');
    echo json_encode($villes);
} catch(PDOException $e) {
    header('HTTP/1.1 500 Internal Server Error');
    echo json_encode(['error' => $e->getMessage()]);
}
?>