import pandas as pd
import sqlite3

def process_commune_data():
    # Charger les données depuis le fichier CSV
    try:
        # Spécifier le séparateur ';' au lieu de ','
        df = pd.read_csv(r"C:\xampp\htdocs\site_web\py\communes.csv", sep=";", engine="python", skip_blank_lines=True, on_bad_lines="skip")
        print("Fichier communes.csv chargé avec succès.")
        print("Colonnes disponibles :", df.columns)  # Afficher les colonnes pour vérifier
    except FileNotFoundError:
        raise Exception("Le fichier communes.csv n'a pas été trouvé.")
    except pd.errors.ParserError as e:
        raise Exception(f"Erreur de parsing : {e}")
    
    # Sélectionner les colonnes nécessaires
    try:
        # Remplacez les colonnes en fonction de votre fichier CSV
        df = df[["Code Officiel Commune", "Nom Officiel Commune", "Code Officiel Département", "Code Officiel Région"]] 
        df.columns = ["code_commune", "nom_commune", "code_departement", "code_region"]
    except KeyError as e:
        raise Exception(f"Colonnes manquantes dans le fichier CSV : {e}")
    
    return df

def create_table():
    # Connexion à la base de données
    conn = sqlite3.connect(r"C:\xampp\htdocs\site_web\db\emploi.db")
    cursor = conn.cursor()

    # Créer la table commune si elle n'existe pas déjà
    cursor.execute("""
        CREATE TABLE IF NOT EXISTS commune (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            code_commune TEXT,
            nom_commune TEXT,
            code_departement TEXT,
            code_region TEXT
        );
    """)

    conn.commit()
    return conn, cursor

def insert_data(cursor, df):
    # Insérer les données dans la base de données
    for index, row in df.iterrows():
        cursor.execute("""
            INSERT INTO commune (code_commune, nom_commune, code_departement, code_region)
            VALUES (?, ?, ?, ?);
        """, (row['code_commune'], row['nom_commune'], row['code_departement'], row['code_region']))
    print("Données insérées dans la base de données.")

def main():
    print("Traitement des données depuis communes.csv...")
    df = process_commune_data()  # Traiter les données
    conn, cursor = create_table()  # Créer la table si elle n'existe pas
    insert_data(cursor, df)  # Insérer les données
    conn.commit()
    conn.close()
    print("Traitement terminé.")

if __name__ == "__main__":
    main()
