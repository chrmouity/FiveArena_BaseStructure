<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<!-- 🔵 Titre de la page -->
<h2 class="text-center mb-4">📅 Mes Réservations</h2>

<!-- 🔔 Affichage des messages d'état -->
<?php if (isset($_GET['deleted'])): ?>
    <div class="alert alert-success">✅ Réservation annulée avec succès.</div>
<?php elseif (isset($_GET['unauthorized'])): ?>
    <div class="alert alert-danger">❌ Vous ne pouvez pas annuler cette réservation.</div>
<?php endif; ?>

<!-- 📋 Si des réservations existent, on les affiche -->
<?php if (!empty($data['reservations'])): ?>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Terrain</th>
                <th>Localisation</th>
                <th>Date</th>
                <th>Heure début</th>
                <th>Heure fin</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data['reservations'] as $resa): ?>
                <tr>
                    <td><?= htmlspecialchars($resa['terrain_nom']) ?></td>
                    <td><?= htmlspecialchars($resa['localisation']) ?></td>
                    <td><?= htmlspecialchars($resa['date']) ?></td>
                    <td><?= htmlspecialchars($resa['heure_debut']) ?></td>
                    <td><?= htmlspecialchars($resa['heure_fin']) ?></td>
                    <td>
                        <!-- 🔴 Bouton qui déclenche la confirmation -->
                        <button class="btn btn-danger btn-sm" onclick="confirmerAnnulation(<?= $resa['id'] ?>)">
                            Annuler
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <!-- 🟡 Aucun résultat -->
    <p class="text-center">Aucune réservation pour le moment.</p>
<?php endif; ?>

<!-- 🧾 Modal de confirmation personnalisé -->
<div id="confirmation-box" class="modal d-none" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmation</h5>
            </div>
            <div class="modal-body">
                <p>Voulez-vous vraiment annuler cette réservation ?</p>
            </div>
            <div class="modal-footer">
                <!-- Bouton pour annuler la suppression -->
                <button type="button" class="btn btn-secondary" onclick="fermerModal()">Non</button>
                <!-- Lien vers la suppression réelle -->
                <a id="btn-confirmer" class="btn btn-danger">Oui, annuler</a>
            </div>
        </div>
    </div>
</div>

<!-- ✅ JavaScript pour gérer le modal -->
<script>
    // Ouvre la boîte de confirmation et prépare le lien de suppression
    function confirmerAnnulation(resaId) {
        const modal = document.getElementById("confirmation-box");
        modal.classList.remove("d-none");

        // Prépare le lien de suppression avec l’ID de la réservation
        document.getElementById("btn-confirmer").href =
            "/FiveArena_BaseStructure/public/Reservation/supprimer/" + resaId;
    }

    // Ferme le modal sans supprimer
    function fermerModal() {
        document.getElementById("confirmation-box").classList.add("d-none");
    }
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
