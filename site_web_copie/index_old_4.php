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
  <input type="text" id="searchInput" placeholder="Rechercher un département..." autocomplete="off">
  <div id="results"></div>
</div>

<!-- Questionnaire après sélection du département -->
<div id="questionnaire" style="display: none;">
  <p>Maintenant on choisit entre la Ville et le Métier :</p>
  <button id="chooseCity">Ville</button>
  <button id="chooseJob">Métier</button>
</div>

<!-- Barre de recherche pour les villes -->
<div class="search-box" id="citySearchBox" style="display: none;">
  <input list="cityList" id="citySearchInput" placeholder="Rechercher une ville..." autocomplete="off">
  <datalist id="cityList">
  <!-- Les options de ville seront ajoutées dynamiquement -->
  </datalist>
</div>

<!-- Barre de recherche pour les métiers -->
<div class="search-box" id="jobSearchBox" style="display: none;">
  <input list="jobList" id="jobSearchInput" placeholder="Rechercher un métier..." autocomplete="off">
  <datalist id="jobList">
  <!-- Les options de métier seront ajoutées dynamiquement -->
  </datalist>
</div>
</div>

<script>
$(document).ready(function(){
const searchInput = $('#searchInput');
const results = $('#results');
const citySearchBox = $('#citySearchBox');
const citySearchInput = $('#citySearchInput');
const questionnaire = $('#questionnaire');
const jobSearchBox = $('#jobSearchBox');
const jobSearchInput = $('#jobSearchInput');

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
  questionnaire.show(); // Afficher le questionnaire

  // Réinitialiser les barres de recherche
  citySearchBox.hide();
  jobSearchBox.hide();
  citySearchInput.val('');
  jobSearchInput.val('');
});

// Gérer le choix entre Ville et Métier
$('#chooseCity').on('click', function() {
  questionnaire.hide();
  citySearchBox.show(); // Afficher la barre de recherche des villes
  jobSearchBox.hide(); // Cacher la barre de recherche des métiers
  jobSearchInput.val(''); // Réinitialiser la saisie des métiers

  // Charger les villes dans le datalist
  const departmentCode = searchInput.val().split(' - ')[0];
  $.ajax({
    url: 'search.php',
    method: 'POST',
    data: { departmentCode: departmentCode, type: 'cityList' },
    success: function(response) {
      $('#cityList').html(response);
    }
  });
});

$('#chooseJob').on('click', function() {
  questionnaire.hide();
  jobSearchBox.show(); // Afficher la barre de recherche des métiers
  citySearchBox.show(); // Afficher la barre de recherche des villes après le choix du métier
  citySearchInput.val(''); // Réinitialiser la saisie des villes

  // Charger les métiers dans le datalist
  $.ajax({
    url: 'search.php',
    method: 'POST',
    data: { type: 'jobList' },
    success: function(response) {
      $('#jobList').html(response);
    }
  });
});

// Gérer la sélection d'une ville
citySearchInput.on('input', function() {
  const city = $(this).val();
  if (city) {
    jobSearchBox.show(); // Afficher la barre de recherche des métiers après la ville
  }
});
});
</script>
</body>
</html>