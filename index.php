<!DOCTYPE html>
<html>
<head>
    <title>Recherche Départements</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="search-container">
        <input type="text" id="searchInput" placeholder="Rechercher un département...">
        <div id="results"></div>
    </div>

    <script>
    $(document).ready(function(){
        $('#searchInput').keyup(function(){
            var search = $(this).val();
            if(search.length > 0){
                $.ajax({
                    url: 'search.php',
                    method: 'POST',
                    data: {query: search},
                    success: function(response){
                        $('#results').html(response);
                    }
                });
            } else {
                $('#results').html('');
            }
        });
    });
    </script>
</body>
</html>