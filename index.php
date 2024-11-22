<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recherche de Départements</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="search-container">
        <h1 class="search-title">Recherche de Départements</h1>
        <div class="search-box">
            <input type="text" 
                   id="searchInput" 
                   placeholder="Rechercher un département..."
                   autocomplete="off">
            <div id="results"></div>
        </div>
        <!-- Nouvelle barre de recherche pour les villes -->
        <div class="search-box" id="citySearchBox" style="display: none;">
            <input type="text" 
                   id="citySearchInput" 
                   placeholder="Rechercher une ville..."
                   autocomplete="off">
            <div id="cityResults"></div>
        </div>
    </div>

    <script>
    $(document).ready(function(){
        const searchInput = $('#searchInput');
        const results = $('#results');
        const citySearchBox = $('#citySearchBox');
        const citySearchInput = $('#citySearchInput');
        const cityResults = $('#cityResults');

        // Afficher les résultats en fonction de la saisie
        searchInput.on('input', function() {
            const query = $(this).val().toLowerCase();
            results.empty();

            if (query) {
                $.ajax({
                    url: 'search.php',
                    method: 'POST',
                    data: { query: query, type: 'department' },
                    success: function(response) {
                        results.html(response);
                    }
                });
            }
        });

        // Gérer la sélection d'un département
        $(document).on('click', '.dept-row', function() {
            const code = $(this).data('code');
            const nom = $(this).data('nom');
            searchInput.val(`${code} - ${nom}`);
            results.empty(); // Effacer les résultats après sélection
            citySearchBox.show(); // Afficher la barre de recherche des villes
            citySearchInput.data('department-code', code); // Stocker le code du département
        });

        // Afficher les résultats des villes en fonction de la saisie
        citySearchInput.on('input', function() {
            const query = $(this).val().toLowerCase();
            const departmentCode = $(this).data('department-code');
            cityResults.empty();

            if (query && departmentCode) {
                $.ajax({
                    url: 'search.php',
                    method: 'POST',
                    data: { query: query, type: 'city', departmentCode: departmentCode },
                    success: function(response) {
                        cityResults.html(response);
                    }
                });
            }
        });
    });
    </script>
</body>
</html>