-- Suppression des tables si elles existent déjà
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS terrains;
DROP TABLE IF EXISTS reservations;

-- Table des utilisateurs
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user'
);

-- Table des terrains
CREATE TABLE terrains (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    localisation VARCHAR(150),
    description TEXT
);

-- Table des réservations
CREATE TABLE reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    terrain_id INT NOT NULL,
    date DATE NOT NULL,
    heure_debut TIME NOT NULL,
    heure_fin TIME NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (terrain_id) REFERENCES terrains(id)
);

-- Ajout d'un administrateur par défaut
INSERT INTO users (username, email, password, role)
VALUES (
    'admin',
    'admin@fivearena.com',
    '$2y$10$abcdefghijklmnopqrstuv',  -- À remplacer par un mot de passe hashé réel
    'admin'
);
