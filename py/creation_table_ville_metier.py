import sqlite3

# Chemin vers votre base de données
db_path = 'C:/xampp/htdocs/site_web/db/emploi.db'

# Connexion à la base de données
try:
  conn = sqlite3.connect(db_path)
  cursor = conn.cursor()

  # Création de la table "ville"
  cursor.execute('''
  CREATE TABLE IF NOT EXISTS ville (
      id INTEGER PRIMARY KEY AUTOINCREMENT,
      code_departement TEXT NOT NULL,
      code_postal TEXT NOT NULL,
      nom_de_la_ville TEXT NOT NULL
  )
  ''')

  # Création de la table "metier"
  cursor.execute('''
  CREATE TABLE IF NOT EXISTS metier (
      id INTEGER PRIMARY KEY AUTOINCREMENT,
      nom TEXT NOT NULL,
      ville_id INTEGER,
      FOREIGN KEY (ville_id) REFERENCES ville(id)
  )
  ''')

  # Sauvegarder les changements et fermer la connexion
  conn.commit()
  print("Tables 'ville' et 'metier' créées avec succès.")
  
except sqlite3.Error as e:
  print(f"Une erreur est survenue : {e}")
finally:
  if conn:
      conn.close()