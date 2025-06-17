<?php
class ReservationController extends Controller {

    // 📅 Page de réservation de terrain
    public function index() {
        session_start();
        if (!isset($_SESSION['user'])) {
            header('Location: /FiveArena_BaseStructure/public/Auth/index');
            exit;
        }

        $terrainModel = $this->model('Terrain');
        $terrains = $terrainModel->getAll();

        $this->view('reservation/index', ['terrains' => $terrains]);
    }

    // ✅ Traitement de la réservation
    public function reserver() {
        session_start();

        if (!isset($_SESSION['user'])) {
            header('Location: /FiveArena_BaseStructure/public/Auth/index');
            exit;
        }

        $user_id = $_SESSION['user']['id'];
        $terrain_id = $_POST['terrain_id'];
        $date = $_POST['date'];
        $heure_debut = $_POST['heure_debut'];
        $heure_fin = $_POST['heure_fin'];

        $reservationModel = $this->model('Reservation');

        // Validation: pas dans le passé
        $now = new DateTime();
        $start = new DateTime("$date $heure_debut");
        if ($start <= $now) {
            header('Location: /FiveArena_BaseStructure/public/Reservation/index?error=past');
            exit;
        }

        // Validation: vérification du créneau disponible
        if (!$reservationModel->isAvailable($terrain_id, $date, $heure_debut, $heure_fin)) {
            header('Location: /FiveArena_BaseStructure/public/Reservation/index?error=1');
            exit;
        }

        // Création de la réservation
        $reservationModel->create($user_id, $terrain_id, $date, $heure_debut, $heure_fin);

        header('Location: /FiveArena_BaseStructure/public/Reservation/index?success=1');
        exit;
    }

    // 📖 Affichage des réservations utilisateur
    public function mesReservations() {
        session_start();

        if (!isset($_SESSION['user'])) {
            header('Location: /FiveArena_BaseStructure/public/Auth/index');
            exit;
        }

        $reservationModel = $this->model('Reservation');
        $reservations = $reservationModel->getByUser($_SESSION['user']['id']);

        $this->view('reservation/mes_reservations', ['reservations' => $reservations]);
    }

    // ❌ Annulation de réservation par l'utilisateur
    public function supprimer($id) {
        session_start();

        $reservationModel = $this->model('Reservation');

        // Vérification de propriétaire
        if ($reservationModel->appartientA($id, $_SESSION['user']['id'])) {
            $reservationModel->delete($id);
            header('Location: /FiveArena_BaseStructure/public/Reservation/mesReservations?deleted=1');
        } else {
            header('Location: /FiveArena_BaseStructure/public/Reservation/mesReservations?unauthorized=1');
        }
        exit;
    }

    // ✅ Envoi de confirmation email (manuel depuis l'admin)
    public function confirmerEmail($id) {
        session_start();
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: /FiveArena_BaseStructure/public/Auth/index');
            exit;
        }

        $reservationModel = $this->model('Reservation');
        $reservations = $reservationModel->getAllWithUserAndTerrain();
        $resa = null;

        foreach ($reservations as $r) {
            if ($r['id'] == $id) {
                $resa = $r;
                break;
            }
        }

        if ($resa) {
            $to = $resa['email'];
            $subject = "Confirmation de votre réservation";
            $message = "Bonjour " . $resa['username'] . ",\n\nVotre réservation pour le " . $resa['terrain_nom'] .
                " à " . $resa['localisation'] . " le " . $resa['date'] . " de " .
                $resa['heure_debut'] . " à " . $resa['heure_fin'] . " est bien confirmée.\n\nMerci.";
            $headers = "From: no-reply@fivearena.com";

            mail($to, $subject, $message, $headers);

            $reservationModel->markAsNotified($id);
            header('Location: /FiveArena_BaseStructure/public/Admin/index?mail=sent');
            exit;
        }
    }
}
