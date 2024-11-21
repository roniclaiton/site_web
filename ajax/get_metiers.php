<?php
try {
    $db = new PDO('sqlite:../db/database.sqlite');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $ville = $_POST['ville'];
    $stmt = $db->prepare('SELECT * FROM metier WHERE ville = ? ORDER BY nom_metier');
    $stmt->execute([$ville]);
    $metiers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    header('Content-Type: application/json');
    echo json_encode($metiers);
} catch(PDOException $e) {
    header('HTTP/1.1 500 Internal Server Error');
    echo json_encode(['error' => $e->getMessage()]);
}
?>