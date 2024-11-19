#!/usr/bin/env python3
# -*- coding: utf-8 -*-

"""
Script d'insertion de données dans la base de données emploi
Auteur: Roni Claiton Vilhena Silva
Date: 19/11/2024
"""

import sqlite3
from typing import List, Tuple
import logging

# Configuration du logging
logging.basicConfig(
  level=logging.INFO,
  format='%(asctime)s - %(levelname)s - %(message)s'
)
logger = logging.getLogger(__name__)

# Constantes
DATABASE_NAME = 'emploi.db'

# Données à insérer
ENTREPRISES_DATA = [
  ('Entreprise A', 'Technologie'),
  ('Entreprise B', 'Finance')
]

OFFRES_DATA = [
  ('Développeur Web', 'Développement de sites web', 1),
  ('Analyste Financier', 'Analyse des marchés financiers', 2)
]

class DatabaseInserter:
  """Classe pour gérer l'insertion des données dans la base"""
  
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
          logger.error(f"Erreur de connexion à la base de données: {e}")
          raise

  def insert_entreprises(self, entreprises_data: List[Tuple[str, str]]) -> None:
      """
      Insère les données des entreprises
      
      Args:
          entreprises_data: Liste de tuples (nom, secteur)
      """
      try:
          self.cursor.executemany(
              "INSERT INTO entreprises (nom, secteur) VALUES (?, ?)",
              entreprises_data
          )
          logger.info(f"{len(entreprises_data)} entreprises insérées avec succès")
      except sqlite3.Error as e:
          logger.error(f"Erreur lors de l'insertion des entreprises: {e}")
          self.conn.rollback()
          raise

  def insert_offres(self, offres_data: List[Tuple[str, str, int]]) -> None:
      """
      Insère les données des offres d'emploi
      
      Args:
          offres_data: Liste de tuples (titre, description, entreprise_id)
      """
      try:
          self.cursor.executemany(
              "INSERT INTO offres (titre, description, entreprise_id) VALUES (?, ?, ?)",
              offres_data
          )
          logger.info(f"{len(offres_data)} offres d'emploi insérées avec succès")
      except sqlite3.Error as e:
          logger.error(f"Erreur lors de l'insertion des offres: {e}")
          self.conn.rollback()
          raise

  def commit_and_close(self) -> None:
      """Valide les changements et ferme la connexion"""
      try:
          if self.conn:
              self.conn.commit()
              logger.info("Changements validés avec succès")
              self.conn.close()
              logger.info("Connexion fermée")
      except sqlite3.Error as e:
          logger.error(f"Erreur lors de la fermeture de la connexion: {e}")
          raise

def main() -> None:
  """Fonction principale du script"""
  db_inserter = None
  try:
      # Initialisation de l'inserteur de données
      db_inserter = DatabaseInserter(DATABASE_NAME)
      
      # Connexion et insertion des données
      db_inserter.connect()
      db_inserter.insert_entreprises(ENTREPRISES_DATA)
      db_inserter.insert_offres(OFFRES_DATA)
      
  except Exception as e:
      logger.error(f"Une erreur est survenue: {e}")
      raise
  
  finally:
      # Validation et fermeture dans tous les cas
      if db_inserter:
          db_inserter.commit_and_close()

if __name__ == "__main__":
  main()