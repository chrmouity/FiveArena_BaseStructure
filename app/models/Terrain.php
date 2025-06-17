<?php
// app/models/Terrain.php

class Terrain {
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    // Récupère tous les terrains (y compris l’image)
    public function getAll() {
        $stmt = $this->db->prepare("SELECT * FROM terrains");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM terrains WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Ajoute un terrain avec image
    public function add($nom, $localisation, $description, $image) {
        $stmt = $this->db->prepare("INSERT INTO terrains (nom, localisation, description, image) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nom, $localisation, $description, $image]);
    }

    // Met à jour un terrain
    public function update($id, $nom, $localisation, $description, $image) {
        $stmt = $this->db->prepare("UPDATE terrains SET nom = ?, localisation = ?, description = ?, image = ? WHERE id = ?");
        $stmt->execute([$nom, $localisation, $description, $image, $id]);
    }

    // Supprime un terrain
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM terrains WHERE id = ?");
        $stmt->execute([$id]);
    }
}
