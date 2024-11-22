<?php
try {
    // Connexion à la base de données SQLite
    $db = new PDO('sqlite:C:/xampp/htdocs/site_web/db/emploi.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_POST['query']) && isset($_POST['type'])) {
        $search = $_POST['query'];
        $type = $_POST['type'];

        if ($type === 'department') {
            // Requête SQL pour les départements
            $query = $db->prepare("SELECT * FROM departement 
                                   WHERE nom LIKE :search 
                                   OR code LIKE :search
                                   ORDER BY code ASC");
        } elseif ($type === 'city' && isset($_POST['departmentCode'])) {
            // Requête SQL pour les villes
            $departmentCode = $_POST['departmentCode'];
            $query = $db->prepare("SELECT * FROM ville 
                                   WHERE nom_de_la_ville LIKE :search 
                                   AND code_departement = :departmentCode
                                   ORDER BY nom_de_la_ville ASC");
            $query->bindParam(':departmentCode', $departmentCode, PDO::PARAM_STR);
        }

        $search = '%' . $search . '%';
        $query->bindParam(':search', $search, PDO::PARAM_STR);
        $query->execute();

        $results = $query->fetchAll(PDO::FETCH_ASSOC);

        if (count($results) > 0) {
            echo "<table>";
            echo "<tr>
                  <th>Code</th>
                  <th>Nom</th>
                  </tr>";

            foreach ($results as $row) {
                echo "<tr class='dept-row' 
                      data-code='" . htmlspecialchars($row['code']) . "' 
                      data-nom='" . htmlspecialchars($row['nom']) . "'>";
                echo "<td class='dept-code'>" . htmlspecialchars($row['code']) . "</td>";
                echo "<td class='dept-name'>" . htmlspecialchars($row['nom']) . "</td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "<div class='no-result'>
                  <p>Aucun résultat trouvé pour : '" . htmlspecialchars($search) . "'</p>
                  <p>Essayez avec un autre terme de recherche</p>
                  </div>";
        }
    }
} catch (PDOException $e) {
    echo "<div class='error-message'>
          Une erreur est survenue lors de la connexion à la base de données.<br>
          Veuillez réessayer plus tard.
          </div>";
    // Log de l'erreur pour l'administrateur
    error_log("Erreur Base de données: " . $e->getMessage());
}
?>