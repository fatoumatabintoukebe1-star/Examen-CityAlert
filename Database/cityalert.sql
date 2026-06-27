CREATE DATABASE IF NOT EXISTS cityalert
CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE cityalert;-- Table utilisateurs
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
nom VARCHAR(100) NOT NULL,
prenom VARCHAR(100) NOT NULL,
email VARCHAR(191) NOT NULL UNIQUE,
mot_de_passe VARCHAR(255) NOT NULL,
role ENUM('citoyen','agent','administrateur') NOT NULL DEFAULT 'citoyen',
telephone VARCHAR(20),
adresse TEXT,
categorie VARCHAR(100),
matricule VARCHAR(50),
actif TINYINT(1) NOT NULL DEFAULT 1,
created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;-- Table catégories
CREATE TABLE categories (
id INT AUTO_INCREMENT PRIMARY KEY,
nom VARCHAR(100) NOT NULL,
type ENUM('voirie','eclairage','dechets','eau') NOT NULL,
description TEXT,
created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;-- Table signalements
CREATE TABLE signalements (
id INT AUTO_INCREMENT PRIMARY KEY,
titre VARCHAR(255) NOT NULL,
description TEXT NOT NULL,
adresse VARCHAR(255) NOT NULL,
photo VARCHAR(255),
statut ENUM('Nouveau','EnCours','Resolu','Rejete') NOT NULL DEFAULT 'Nouveau',
priorite ENUM('basse','moyenne','haute','urgente') NOT NULL DEFAULT 'moyenne',
citoyen_id INT NOT NULL,
categorie_id INT NOT NULL,
created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
FOREIGN KEY (citoyen_id) REFERENCES users(id),
FOREIGN KEY (categorie_id) REFERENCES categories(id)
) ENGINE=InnoDB;-- Table commentaires
CREATE TABLE commentaires (
id INT AUTO_INCREMENT PRIMARY KEY,
contenu TEXT NOT NULL,
auteur_id INT NOT NULL,
signalement_id INT NOT NULL,
created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
FOREIGN KEY (auteur_id) REFERENCES users(id),
FOREIGN KEY (signalement_id) REFERENCES signalements(id) ON DELETE CASCADE
) ENGINE=InnoDB;-- Table historique des statuts
CREATE TABLE historique_statuts (
id INT AUTO_INCREMENT PRIMARY KEY,
signalement_id INT NOT NULL,
agent_id INT NOT NULL,
ancien_statut VARCHAR(50) NOT NULL,
nouveau_statut VARCHAR(50) NOT NULL,
commentaire TEXT,
date_changement DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
FOREIGN KEY (signalement_id) REFERENCES signalements(id) ON DELETE CASCADE,
FOREIGN KEY (agent_id) REFERENCES users(id)
) ENGINE=InnoDB;
INSERT INTO users (nom, prenom, email, mot_de_passe, role) VALUES
('Admin', 'CityAlert', 'admin@cityalert.sn',
'$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'administrateur'),
('Diallo', 'Mamadou', 'agent@cityalert.sn',
'$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'agent'),
('Sow', 'Fatou', 'citoyen@cityalert.sn',
'$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'citoyen');-- NB : le hash correspond au mot de passe 'password123'
INSERT INTO categories (nom, type, description) VALUES
('Voirie et routes', 'voirie', 'Routes dégradées, nids de poule, trottoirs'),
('Éclairage public', 'eclairage', 'Lampadaires défaillants, zones sombres'),
('Déchets et propreté', 'dechets', 'Dépôts sauvages, poubelles débordantes'),
('Eau et assainissement', 'eau', 'Fuites d\'eau, inondations, égouts');