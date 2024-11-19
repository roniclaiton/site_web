#!/usr/bin/env python3
# -*- coding: utf-8 -*-

"""
Script de création de base de données pour un système de gestion d'emplois
Auteur: Roni Claiton Vilhena Silva
Date de création: 19/11/2024
"""

import sqlite3
from typing import Any
import logging

# Configuration du logging
logging.basicConfig(
  level=logging.INFO,
  format='%(asctime)s - %(levelname)s - %(message)s'
)
logger = logging.getLogger(__name__)

# Constantes
DATABASE_NAME = 'emploi.db'

# Définition des requêtes SQL
SQL_CREATE_ENTREPRISES = '''
CREATE TABLE IF NOT EXISTS entreprises (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  nom TEXT NOT NULL,
  description TEXT,
  contact TEXT
)
'''

SQL_CREATE_OFFRES = '''
CREATE TABLE IF NOT EXISTS offres (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  titre TEXT NOT NULL,
  description TEXT,
  localisation TEXT,
  entreprise_id INTEGER,
  FOREIGN KEY (entreprise_id) REFERENCES entreprises (id)
)
'''

class DatabaseManager:
  """Gestionnaire de base de données pour le système d'emploi"""
  
  def __init__(self, db_name: str):
      """
      Initialise la connexion à la base de données
      
      Args:
          db_name (str): Nom du fichier de base de données
      """
      self.db_name = db_name
      self.conn = None
      self.cursor = None

  def connect(self) -> None:
      """Établit la connexion à la base de données"""
      try:
          self.conn = sqlite3.connect(self.db_name)
          self.cursor = self.conn.cursor()
          logger.info(f"Connexion établie à la base de données {self.db_name}")
      except sqlite3.Error as e:
          logger.error(f"Erreur lors de la connexion à la base de données: {e}")
          raise

  def create_tables(self) -> None:
      """Crée les tables nécessaires dans la base de données"""
      try:
          # Création de la table des entreprises
          self.cursor.execute(SQL_CREATE_ENTREPRISES)
          logger.info("Table 'entreprises' créée avec succès")

          # Création de la table des offres d'emploi
          self.cursor.execute(SQL_CREATE_OFFRES)
          logger.info("Table 'offres' créée avec succès")

      except sqlite3.Error as e:
          logger.error(f"Erreur lors de la création des tables: {e}")
          raise

  def close_connection(self) -> None:
      """Ferme la connexion à la base de données"""
      try:
          if self.conn:
              self.conn.commit()
              self.conn.close()
              logger.info("Connexion à la base de données fermée")
      except sqlite3.Error as e:
          logger.error(f"Erreur lors de la fermeture de la connexion: {e}")
          raise

def main() -> None:
  """Fonction principale du script"""
  try:
      # Initialisation du gestionnaire de base de données
      db_manager = DatabaseManager(DATABASE_NAME)
      
      # Création de la base de données et des tables
      db_manager.connect()
      db_manager.create_tables()
      
  except Exception as e:
      logger.error(f"Une erreur est survenue: {e}")
      raise
  
  finally:
      # Fermeture de la connexion dans tous les cas
      if db_manager:
          db_manager.close_connection()

if __name__ == "__main__":
  main()