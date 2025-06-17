<?php

class Reservation {
    private $db;

    public function __construct() {
        // Connexion à la base de données via PDO
        $this->db = Database::connect();
    }

    // 🔹 Crée une nouvelle réservation
    public function create($user_id, $terrain_id, $date, $heure_debut, $heure_fin) {
        $stmt = $this->db->prepare("INSERT INTO reservations (user_id, terrain_id, date, heure_debut, heure_fin)
                                    VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$user_id, $terrain_id, $date, $heure_debut, $heure_fin]);
    }

    // 🔎 Vérifie si un créneau est disponible (aucun chevauchement)
    public function isAvailable($terrain_id, $date, $heure_debut, $heure_fin) {
        $stmt = $this->db->prepare("SELECT * FROM reservations
                                    WHERE terrain_id = ?
                                      AND date = ?
                                      AND (
                                          (heure_debut < ? AND heure_fin > ?) -- chevauchement
                                          OR (heure_debut >= ? AND heure_debut < ?)
                                      )");
        $stmt->execute([
            $terrain_id,
            $date,
            $heure_fin,     // heure de fin de la réservation proposée
            $heure_debut,   // heure de début de la réservation proposée
            $heure_debut,
            $heure_fin
        ]);
        return $stmt->rowCount() === 0; // true = créneau libre
    }

    // 📄 Récupère les réservations faites par un utilisateur
    public function getByUser($user_id) {
        $stmt = $this->db->prepare("SELECT r.id, t.nom AS terrain_nom, t.localisation, r.date, r.heure_debut, r.heure_fin
                                    FROM reservations r
                                    JOIN terrains t ON r.terrain_id = t.id
                                    WHERE r.user_id = ?
                                    ORDER BY r.date DESC");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 🔐 Vérifie que la réservation appartient bien à cet utilisateur
    public function appartientA($reservation_id, $user_id) {
        $stmt = $this->db->prepare("SELECT * FROM reservations WHERE id = ? AND user_id = ?");
        $stmt->execute([$reservation_id, $user_id]);
        return $stmt->rowCount() > 0;
    }

    // ❌ Supprime une réservation
    public function delete($reservation_id) {
        $stmt = $this->db->prepare("DELETE FROM reservations WHERE id = ?");
        $stmt->execute([$reservation_id]);
    }

    // 🗂 Récupère toutes les réservations avec utilisateur + terrain (vue admin)
    public function getAllWithUserAndTerrain() {
        $stmt = $this->db->prepare("SELECT r.id, r.date, r.heure_debut, r.heure_fin,
                                           t.nom AS terrain_nom, t.localisation,
                                           u.username, u.email,
                                           r.notified
                                    FROM reservations r
                                    JOIN terrains t ON r.terrain_id = t.id
                                    JOIN users u ON r.user_id = u.id
                                    ORDER BY r.date DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // 📌 Récupère une réservation par son ID avec les infos utilisateur et terrain
public function getOneWithUserAndTerrain($id) {
    $stmt = $this->db->prepare("
        SELECT 
            r.id,
            r.date,
            r.heure_debut,
            r.heure_fin,
            t.nom AS terrain_nom,
            t.localisation,
            u.username,
            u.email
        FROM reservations r
        JOIN terrains t ON r.terrain_id = t.id
        JOIN users u ON r.user_id = u.id
        WHERE r.id = ?
        LIMIT 1
    ");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC); // retourne une seule réservation
}


    // ✅ Marque une réservation comme "notifiée"
    public function markAsNotified($id) {
        $stmt = $this->db->prepare("UPDATE reservations SET notified = 1 WHERE id = ?");
        $stmt->execute([$id]);
    }
}
