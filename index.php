<?php
// Démarrage de la session
session_start();

// Connexion à la base de données SQLite
try {
    $db = new PDO('sqlite:C:/xampp/htdocs/site_web/db/database.sqlite');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Fonction pour récupérer les départements
function getDepartements($db) {
    try {
        $stmt = $db->query('SELECT * FROM departement ORDER BY code_departement');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        return [];
    }
}

// Récupération des départements pour le select
$departements = getDepartements($db);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JeJob.fr - Offres d'Emploi</title>
    <!-- Remplacer les chemins Flask par des chemins PHP -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="js/main.js"></script>
</head>
<body>
    <h1>Bienvenue dans Je travail.fr</h1>
    
    <!-- Navigation -->
    <nav>
        <div class="logo">Bienvenue sur JeJob.fr</div>
        <ul>
            <li><a href="#criteres">Critères de Recherche</a></li>
            <li><a href="#entreprises">Profils d'Entreprises</a></li>
            <li><a href="#offres">Offres d'Emploi</a></li>
            <li><a href="#equipe">Notre équipe</a></li>
            <li><a href="#contact">Contact</a></li>
        </ul>
    </nav>
    
    <!-- Section Critères de Recherche -->
    <section id="criteres">
        <h1>Critères de Recherche d'Emploi</h1>
        <ul>
            <li>
                <!-- Formulaire de Recherche -->
                <form action="php/traitement.php" method="POST" onsubmit="return validateForm()">
                    <input type="hidden" name="default_department_id" value="12345">
                    <label for="departement">Département (Code Postal):</label>
                    <select id="departement" name="departement" required>
                        <option value="">Sélectionnez un département</option>
                        <?php foreach($departements as $departement): ?>
                            <option value="<?php echo htmlspecialchars($departement['code_departement']); ?>">
                                <?php echo htmlspecialchars($departement['nom_departement']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit">Rechercher</button>
                </form>
            </li>
            <li>
                <form action="php/traitement.php" method="POST" onsubmit="return validateForm()">
                    <input type="hidden" name="default_department_id" value="12345">
                    <label for="ville">Ville :</label>
                    <input type="text" id="ville" name="ville" placeholder="Entrez la ville" required disabled>
                    <datalist id="villes-list"></datalist>
                    <button type="submit">Rechercher</button>
                </form>
            </li>
            <li>
                <form action="php/traitement.php" method="POST" onsubmit="return validateForm()">
                    <input type="hidden" name="default_department_id" value="12345">
                    <label for="niveau_etude">Métier :</label>
                    <input type="text" id="metier" name="metier" placeholder="Entrez le métier" required disabled>
                    <datalist id="metiers-list"></datalist>
                    <button type="submit">Rechercher</button>
                </form>
            </li>
            <li>
                <h2>Choisissez le type de contrat :</h2>
                <form>
                    <div class="options">
                        <input type="radio" id="cdd" name="contrat" value="CDD">
                        <label for="cdd">CDD</label>
                        
                        <input type="radio" id="cdi" name="contrat" value="CDI">
                        <label for="cdi">CDI</label>
                    </div>
                </form>
            </li>
            <li>Profession</li>
        </ul>
    </section>

    <!-- Formulaire de contact -->
    <div id="message"></div>
    <form action="php/traitement.php" method="POST" onsubmit="return validateForm()">
        <div class="form-group">
            <label for="nom">Nom:*</label>
            <input type="text" id="nom" name="nom" required>
        </div>
        <div class="form-group">
            <label for="prenom">Prénom:*</label>
            <input type="text" id="prenom" name="prenom" required>
        </div>
        <div class="form-group">
            <label for="telephone">Téléphone:* (format: XX.XX.XX.XX.XX)</label>
            <input type="tel" id="telephone" name="telephone"
                   pattern="[0-9]{2}\.[0-9]{2}\.[0-9]{2}\.[0-9]{2}\.[0-9]{2}"
                   placeholder="XX.XX.XX.XX.XX" required>
        </div>
        <div class="form-group">
            <input type="submit" value="Envoyer">
        </div>
    </form>

    <!-- Section Profils d'Entreprises -->
    <section id="entreprises">
        <h2>Profils d'Entreprises</h2>
        <p>Découvrez les entreprises et leurs offres d'emploi. Connectez-vous directement via WhatsApp pour plus d'informations.</p>
        <!-- Le contenu des entreprises sera généré dynamiquement par PHP -->
    </section>

    <!-- Section Offres d'Emploi -->
    <section id="offres">
        <h2>Offres d'Emploi</h2>
        <!-- Le contenu des offres sera généré dynamiquement par PHP -->
    </section>

    <!-- Section Équipe -->
    <section id="equipe">
        <h2>Notre Équipe</h2>
        <div class="team-container">
            <div class="team-member">
                <img src="images/founder.jpg" alt="Roni Claiton">
                <h3>Roni Claiton</h3>
                <p>Fondateur</p>
                <p>Expert en solutions WhatsApp Business</p>
            </div>
            <div class="team-member">
                <img src="images/coordinator.jpg" alt="Valérie Moreno">
                <h3>Valérie Moreno</h3>
                <p>Coordinatrice de Projet</p>
                <p>Spécialiste en gestion de projet</p>
            </div>
            <div class="team-member">
                <img src="images/animator.jpg" alt="Thibault Moreno Silva">
                <h3>Thibault Moreno Silva</h3>
                <p>Animateur d'Événements</p>
                <p>Expert en formation et animation</p>
            </div>
        </div>
    </section>

    <!-- Section Contact -->
    <section id="contact">
        <h2>Contactez-nous</h2>
        <div class="contact-container">
            <i class="fab fa-whatsapp"></i>
            <h3>WhatsApp Business</h3>
            <p>06.03.86.34.44</p>
            <a href="https://wa.me/33603863444" class="whatsapp-button">
                Nous contacter sur WhatsApp
            </a>
        </div>
    </section>

    <footer>
        <p>&copy; 2024 JeJob.fr. Tous droits réservés.</p>
    </footer>

    <!-- Pop-up de message -->
<div id="popup-overlay" class="popup-overlay">
    <div class="popup">
        <div id="popup-message"></div>
        <button class="popup-close" onclick="closePopup()">Fermer</button>
    </div>
</div>

<!-- Script modifié -->
<script>
function validateForm() {
    var tel = document.getElementById('telephone').value;
    var telPattern = /^[0-9]{2}\.[0-9]{2}\.[0-9]{2}\.[0-9]{2}\.[0-9]{2}$/;
    
    if (!telPattern.test(tel)) {
        alert("Le numéro de téléphone doit être au format XX.XX.XX.XX.XX");
        return false;
    }
    return true;
}

function showPopup(message, isSuccess) {
    const popup = document.getElementById('popup-overlay');
    const messageDiv = document.getElementById('popup-message');
    
    messageDiv.innerHTML = message;
    messageDiv.className = isSuccess ? 'popup-success' : 'popup-error';
    popup.style.display = 'block';
}

function closePopup() {
    document.getElementById('popup-overlay').style.display = 'none';
    // Si c'est un succès, on peut rafraîchir la page ou rediriger
    if (document.getElementById('popup-message').classList.contains('popup-success')) {
        window.location.href = 'index.html';
    }
}

window.onload = function() {
    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get('status');
    
    if (status === 'success') {
        showPopup('Merci ! Vos informations ont été enregistrées avec succès.', true);
    } else if (status === 'error') {
        showPopup('Une erreur est survenue. Veuillez réessayer.', false);
    }
}
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
        const departementSelect = document.getElementById('departement');
        const villeInput = document.getElementById('ville');
        const metierInput = document.getElementById('metier');

        departementSelect.addEventListener('change', function() {
            const departement = this.value;
            if (departement) {
                fetch('ajax/get_villes.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `departement=${departement}`
                })
                .then(response => response.json())
                .then(data => {
                    villeInput.disabled = false;
                    const datalist = document.getElementById('villes-list');
                    datalist.innerHTML = '';
                    data.forEach(ville => {
                        const option = document.createElement('option');
                        option.value = ville.nom_ville;
                        datalist.appendChild(option);
                    });
                });
            }
        });

        villeInput.addEventListener('change', function() {
            const ville = this.value;
            if (ville) {
                fetch('ajax/get_metiers.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `ville=${ville}`
                })
                .then(response => response.json())
                .then(data => {
                    metierInput.disabled = false;
                    const datalist = document.getElementById('metiers-list');
                    datalist.innerHTML = '';
                    data.forEach(metier => {
                        const option = document.createElement('option');
                        option.value = metier.nom_metier;
                        datalist.appendChild(option);
                    });
                });
            }
        });
    });
</script>
</body>
</html>