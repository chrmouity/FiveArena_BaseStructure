<?php
// app/models/User.php

// Ce modèle interagit avec la table "users" de la base de données

class User {
    private $db;

    // Connexion à la base de données à l'instanciation
    public function __construct() {
        $this->db = Database::connect();
    }

    // 🔍 Recherche un utilisateur par son nom d'utilisateur
    public function findByUsername($username) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // 🔍 Recherche un utilisateur par email (utilisé à la connexion)
    public function findByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ➕ Inscription : ajoute un nouvel utilisateur
    public function register($username, $email, $password) {
        $stmt = $this->db->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$username, $email, $password]);
    }

    // 🔐 Vérifie si un utilisateur est admin
    public function isAdmin($userId) {
        $stmt = $this->db->prepare("SELECT role FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        $user = $stmt->fetch();
        return $user && $user['role'] === 'admin';
    }
}
