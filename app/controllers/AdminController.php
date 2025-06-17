<?php

class AdminController extends Controller {

    // 🔒 Fonction de sécurité pour restreindre l'accès aux admins
    private function verifierAdmin() {
        session_start();
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: /FiveArena_BaseStructure/public/Auth/index');
            exit;
        }
    }

    // 📄 Page principale d'administration (liste des réservations)
    public function index() {
        $this->verifierAdmin();

        $reservationModel = $this->model('Reservation');
        $reservations = $reservationModel->getAllWithUserAndTerrain();

        $this->view('admin/manage_terrain', ['reservations' => $reservations]);
    }

    // ❌ Suppression d'une réservation (admin uniquement)
    public function supprimer($id) {
        $this->verifierAdmin();

        $reservationModel = $this->model('Reservation');
        $reservationModel->delete($id);

        // Redirection avec message de succès
        header('Location: /FiveArena_BaseStructure/public/Admin/index?deleted=1');
        exit;
    }

    // ✉️ Envoi d'un e-mail de confirmation + mise à jour "notified"
    public function confirmerReservation($id) {
        $this->verifierAdmin();

        $reservationModel = $this->model('Reservation');
        $resa = $reservationModel->getOneWithUserAndTerrain($id); // méthode à bien définir dans Reservation.php

        if ($resa) {
            // 📧 Préparation de l'e-mail
            $to = $resa['email'];
            $subject = "Confirmation de votre réservation - FiveArena";
            $message = "Bonjour " . $resa['username'] . ",\n\n"
                     . "Votre réservation du " . $resa['date']
                     . " de " . $resa['heure_debut'] . " à " . $resa['heure_fin']
                     . " pour le terrain " . $resa['terrain_nom']
                     . " à " . $resa['localisation'] . " est bien confirmée.\n\n"
                     . "Merci pour votre confiance !\nL'équipe FiveArena.";

            $headers = "From: noreply@fivearena.com";

            // 📤 Envoi
            mail($to, $subject, $message, $headers);

            // ✅ Mise à jour dans la BDD (notified = 1)
            $reservationModel->markAsNotified($id);
        }

        // Redirection avec message
        header('Location: /FiveArena_BaseStructure/public/Admin/index?sent=1');
        exit;
    }
}
