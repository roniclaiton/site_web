from fpdf import FPDF

# Create instance of FPDF class
pdf = FPDF()

# Add a page
pdf.add_page()

# Set title with a Unicode font
pdf.add_font("DejaVu", "", "DejaVuSans.ttf", uni=True)
pdf.set_font("DejaVu", '', 16)
pdf.cell(200, 10, txt="Site Web pour Aider les Chômeurs à Trouver un Travail", new_x="LMARGIN", new_y="NEXT", align='C')

# Add some space
pdf.ln(10)

# Set font for the content
pdf.set_font("DejaVu", size=12)

# Page content
content = """
1. Page d'accueil
- Titre accrocheur : "Trouve ton emploi en trois étapes simples !"
- Slogan : "Trois chemins pour trouver ton travail"
- Introduction courte : "Bienvenue sur notre plateforme qui te permet de contacter directement les entreprises sans passer par des intermédiaires. Oublie les CV et lettres de motivation, tu n’as qu’à fournir tes coordonnées et choisir les critères qui te correspondent."

2. Section 1 : Pourquoi choisir notre site ?
- Directe et rapide : "Bénéficie d’un contact direct avec les entreprises locales. Pas besoin d'attendre des réponses automatisées."
- Simplicité : "Nous te demandons uniquement tes coordonnées (prénom, nom, numéro de téléphone) pour te faciliter la communication avec les recruteurs."
- Sans intermédiaires : "Fini les plateformes de recherche d’emploi complexes. Trouve ce qui te correspond directement, et sois contacté via WhatsApp."

3. Section 2 : Comment ça marche ?
- Étape 1 : Choisis ton département, ta ville et ton métier.
"Renseigne simplement ta localisation et le secteur que tu recherches pour que nous puissions te montrer les offres les plus pertinentes."
- Étape 2 : Remplis tes coordonnées.
"Il te suffit de nous fournir ton prénom, ton nom et ton numéro de portable. Aucune lettre de motivation, ni CV requis."
- Étape 3 : Sois contacté directement par les entreprises via WhatsApp.
"Les recruteurs te contacteront directement sur WhatsApp, pour une réponse rapide et personnalisée."

4. Section 3 : Formulaire de recherche
- Titre : "Trouvez ton travail aujourd'hui !"
- Un formulaire pour renseigner les critères : département, ville, métier.
- Bouton "Chercher des offres" pour afficher les résultats.

5. Section 4 : FAQ
- "Dois-je déposer un CV ou une lettre de motivation ?"
*Non, il te suffit de fournir tes coordonnées pour être contacté directement via WhatsApp.*

- "Les entreprises me contacteront-elles immédiatement ?"
*Une fois que tu as rempli le formulaire, les recruteurs te contacteront directement sur WhatsApp. Le temps d’attente peut varier selon les disponibilités des entreprises.*

- "Comment mes informations seront-elles utilisées ?"
*Tes informations seront exclusivement utilisées pour te mettre en contact avec les recruteurs. Nous ne partagerons pas tes données avec des tiers.*

6. Section 5 : Contact
- "Des questions ?"
"N’hésite pas à nous envoyer un message via WhatsApp pour toute question ou pour obtenir plus d’informations."
"""

# Write the content to the PDF
pdf.multi_cell(0, 10, content)

# Save the PDF to a file
output_path = "Guide_Site_Emploi_Chomeur.pdf"
pdf.output(output_path)

print(output_path)