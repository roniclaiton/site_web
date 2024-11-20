import sqlite3

# Connexion à la base de données
conn = sqlite3.connect('db/emploi.db')
cursor = conn.cursor()

# Création du tableau departement
cursor.execute('''
CREATE TABLE IF NOT EXISTS departement (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  code TEXT NOT NULL UNIQUE,
  nom TEXT NOT NULL
)
''')

# Sauvegarder les changements et fermer la connexion
conn.commit()
conn.close()