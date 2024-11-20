<?php
// search.php
header('Content-Type: application/json');

// Connexion à la base de données
try {
    $pdo = new PDO(
        "mysql:host=localhost;dbname=jejob;charset=utf8",
        "votre_utilisateur",
        "votre_mot_de_passe",
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
} catch(PDOException $e) {
    die(json_encode(['error' => 'Connexion échouée : ' . $e->getMessage()]));
}

// Fonction pour nettoyer les entrées
function cleanInput($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

// Traitement de la requête AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = isset($_POST['action']) ? cleanInput($_POST['action']) : '';
    
    switch($action) {
        case 'getVilles':
            // Récupérer les villes pour un département donné
            $departement = isset($_POST['departement']) ? cleanInput($_POST['departement']) : '';
            if (!empty($departement)) {
                try {
                    $stmt = $pdo->prepare("SELECT DISTINCT ville FROM villes WHERE code_departement = ?");
                    $stmt->execute([$departement]);
                    $villes = $stmt->fetchAll();
                    echo json_encode(['success' => true, 'villes' => $villes]);
                } catch(PDOException $e) {
                    echo json_encode(['error' => 'Erreur lors de la récupération des villes']);
                }
            }
            break;

        case 'getMetiers':
            // Récupérer les métiers disponibles pour une ville
            $ville = isset($_POST['ville']) ? cleanInput($_POST['ville']) : '';
            if (!empty($ville)) {
                try {
                    $stmt = $pdo->prepare("SELECT DISTINCT metier FROM offres_emploi WHERE ville = ?");
                    $stmt->execute([$ville]);
                    $metiers = $stmt->fetchAll();
                    echo json_encode(['success' => true, 'metiers' => $metiers]);
                } catch(PDOException $e) {
                    echo json_encode(['error' => 'Erreur lors de la récupération des métiers']);
                }
            }
            break;

        case 'rechercher':
            // Recherche complète avec tous les critères
            $departement = isset($_POST['departement']) ? cleanInput($_POST['departement']) : '';
            $ville = isset($_POST['ville']) ? cleanInput($_POST['ville']) : '';
            $metier = isset($_POST['metier']) ? cleanInput($_POST['metier']) : '';
            
            try {
                $sql = "SELECT * FROM offres_emploi WHERE 1=1";
                $params = [];
                
                if (!empty($departement)) {
                    $sql .= " AND code_departement = ?";
                    $params[] = $departement;
                }
                if (!empty($ville)) {
                    $sql .= " AND ville = ?";
                    $params[] = $ville;
                }
                if (!empty($metier)) {
                    $sql .= " AND metier = ?";
                    $params[] = $metier;
                }
                
                $stmt = $pdo->prepare($sql);
                $stmt->execute($params);
                $resultats = $stmt->fetchAll();
                
                echo json_encode([
                    'success' => true,
                    'resultats' => $resultats
                ]);
            } catch(PDOException $e) {
                echo json_encode(['error' => 'Erreur lors de la recherche']);
            }
            break;
            
        default:
            echo json_encode(['error' => 'Action non reconnue']);
    }
} else {
    echo json_encode(['error' => 'Méthode non autorisée']);
}