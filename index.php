<!-- index.php -->
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
    </div>

    <script>
    $(document).ready(function(){
        const searchInput = $('#searchInput');
        const results = $('#results');

        // Afficher les résultats en fonction de la saisie
        searchInput.on('input', function() {
            const query = $(this).val().toLowerCase();
            results.empty();

            if (query) {
                $.ajax({
                    url: 'search.php',
                    method: 'POST',
                    data: { query: query },
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
        });
    });
    </script>
</body>
</html>