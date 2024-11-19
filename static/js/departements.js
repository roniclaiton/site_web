/**
 * Gestionnaire de sélection de département avec recherche par lettres et chiffres
 */
class DepartementSelector {
    /**
     * Initialise le sélecteur de département
     * @param {string} selectId - L'ID de l'élément select dans le DOM
     */
    constructor(selectId) {
        this.select = document.getElementById(selectId);
        this.searchBuffer = '';
        this.searchTimeout = null;
        
        if (!this.select) {
            console.error(`L'élément avec l'ID ${selectId} n'a pas été trouvé`);
            return;
        }
        
        this.initializeEventListeners();
    }

    /**
     * Initialise les écouteurs d'événements
     */
    initializeEventListeners() {
        this.select.addEventListener('keydown', this.handleKeyDown.bind(this));
    }

    /**
     * Gère l'événement de frappe au clavier
     * @param {KeyboardEvent} event - L'événement keydown
     */
    handleKeyDown(event) {
        // Ignore les touches spéciales
        if (event.key.length > 1) return;
        
        // Ajoute la nouvelle lettre ou chiffre au buffer de recherche
        this.searchBuffer += event.key.toLowerCase();
        
        // Recherche l'option correspondante
        this.findAndSelectOption();
        
        // Réinitialise le timer précédent
        if (this.searchTimeout) {
            clearTimeout(this.searchTimeout);
        }
        
        // Configure un nouveau timer pour effacer le buffer après 1 seconde
        this.searchTimeout = setTimeout(() => {
            this.searchBuffer = '';
        }, 1000);
    }

    /**
     * Recherche et sélectionne l'option correspondante
     * @returns {boolean} - Vrai si une correspondance est trouvée
     */
    findAndSelectOption() {
        const options = this.select.options;
        
        for (let i = 0; i < options.length; i++) {
            const optionText = options[i].text.toLowerCase();
            const optionValue = options[i].value;
            
            // Recherche par texte ou par code département
            if (optionText.startsWith(this.searchBuffer) || 
                optionValue.startsWith(this.searchBuffer)) {
                options[i].selected = true;
                this.notifySelection(options[i]);
                return true;
            }
        }
        
        return false;
    }

    /**
     * Notifie de la sélection d'une option
     * @param {HTMLOptionElement} selectedOption - L'option sélectionnée
     */
    notifySelection(selectedOption) {
        console.log(`Sélectionné : ${optionValue} - ${selectedOption.text} (recherche: ${this.searchBuffer})`);
    }
}

/**
 * Initialisation du sélecteur une fois le DOM chargé
 */
document.addEventListener('DOMContentLoaded', function() {
    try {
        const departementSelector = new DepartementSelector('departement');
    } catch (error) {
        console.error('Erreur lors de l\'initialisation du sélecteur :', error);
    }
});