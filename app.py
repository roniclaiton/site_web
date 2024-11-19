from flask import Flask, render_template, request
from departements import get_departements, get_departement_by_code
import sqlite3
import os
#Auteur: Roni Claiton Vilhena Silva
#Date de création: 19/11/2024
# Chemin absolu vers le dossier de travail
base_dir = 'C:\\Users\\Roni Claiton\\OneDrive\\sitetravail'
app = Flask(__name__, template_folder=os.path.join(base_dir, 'templates'))

def get_db_connection():
  # Utilisation du chemin absolu pour la base de données
  db_path = os.path.join(base_dir, 'emploi.db')
  conn = sqlite3.connect(db_path)
  conn.row_factory = sqlite3.Row
  return conn

@app.route('/')
@app.route('/index.html')
def index():
  # Récupérer les départements
  departements = get_departements()
  
  # Récupérer les offres
  conn = get_db_connection()
  offres = conn.execute('SELECT * FROM offres').fetchall()
  conn.close()
  
  return render_template('index.html', departements=departements, offres=offres)

@app.route('/search', methods=['GET'])
def search_offers():
  departement = request.args.get('departement')
  conn = get_db_connection()
  # Rechercher les offres par département
  offres = conn.execute('SELECT * FROM offres WHERE localisation = ?',
                       (departement,)).fetchall()
  conn.close()
  return render_template('index.html', offres=offres, departements=get_departements(), selected_departement=dept_info)

@app.route('/entreprises')
def show_entreprises():
  conn = get_db_connection()
  cur = conn.cursor()
  cur.execute('SELECT nom, secteur FROM entreprises')
  entreprises = cur.fetchall()
  conn.close()
  return render_template('entreprises.html', entreprises=entreprises)

@app.route('/offres')
def show_offres():
  conn = get_db_connection()
  cur = conn.cursor()
  cur.execute('SELECT titre, description, localisation FROM offres')
  offres = cur.fetchall()
  conn.close()
  return render_template('offres.html', offres=offres)

if __name__ == '__main__':
  app.run(debug=True)