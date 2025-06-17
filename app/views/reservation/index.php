<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<h2 class="text-center mb-4">🏟️ Réserver un terrain</h2>

<!-- ✅ Message de succès -->
<?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success">✅ Réservation effectuée avec succès !</div>

<!-- ❌ Modale : réservation déjà faite -->
<?php elseif (isset($_GET['error']) && $_GET['error'] === '1'): ?>
    <div class="modal show fade" id="error1Modal" tabindex="-1" style="display:block;" aria-modal="true" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content border-warning">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title">Créneau indisponible</h5>
                </div>
                <div class="modal-body">
                    <p>❌ Ce terrain est déjà réservé à cette date et heure. Veuillez choisir un autre créneau.</p>
                </div>
                <div class="modal-footer">
                    <a href="/FiveArena_BaseStructure/public/Reservation/index" class="btn btn-secondary">Fermer</a>
                </div>
            </div>
        </div>
    </div>

<!-- ❌ Modale : réservation dans le passé -->
<?php elseif (isset($_GET['error']) && $_GET['error'] === 'past'): ?>
    <div class="modal show fade" id="pastErrorModal" tabindex="-1" style="display:block;" aria-modal="true" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content border-danger">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Erreur de réservation</h5>
                </div>
                <div class="modal-body">
                    <p>❌ Vous ne pouvez pas réserver une date ou heure déjà passée.</p>
                </div>
                <div class="modal-footer">
                    <a href="/FiveArena_BaseStructure/public/Reservation/index" class="btn btn-secondary">Fermer</a>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- 📝 Formulaire de réservation -->
<form action="/FiveArena_BaseStructure/public/Reservation/reserver" method="post" class="bg-light p-4 rounded shadow-sm" id="reservationForm">

    <!-- 🏟 Choix du terrain -->
    <div class="mb-3">
        <label for="terrain_id" class="form-label">Terrain :</label>
        <select name="terrain_id" id="terrain_id" class="form-select" required>
            <option value="">-- Choisissez un terrain --</option>
            <?php foreach ($data['terrains'] as $terrain): ?>
                <option value="<?= $terrain['id'] ?>">
                    <?= htmlspecialchars($terrain['nom']) ?> - <?= htmlspecialchars($terrain['localisation']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- 📆 Date -->
    <div class="mb-3">
        <label for="date" class="form-label">Date :</label>
        <input type="date" name="date" id="date" class="form-control" required>
    </div>

    <!-- 🕒 Heure de début -->
    <div class="mb-3">
        <label for="heure_debut" class="form-label">Heure de début :</label>
        <input type="time" name="heure_debut" id="heure_debut" class="form-control" required>
    </div>

    <!-- 🕓 Heure de fin -->
    <div class="mb-3">
        <label for="heure_fin" class="form-label">Heure de fin :</label>
        <input type="time" name="heure_fin" id="heure_fin" class="form-control" required>
    </div>

    <!-- 📤 Bouton -->
    <div class="d-grid">
        <button type="submit" class="btn btn-primary">Réserver</button>
    </div>
</form>

<!-- ✅ Script JavaScript de vérification -->
<script>
    document.getElementById('reservationForm').addEventListener('submit', function(e) {
        const date = document.getElementById('date').value;
        const heureDebut = document.getElementById('heure_debut').value;
        const heureFin = document.getElementById('heure_fin').value;

        const now = new Date();
        const start = new Date(date + 'T' + heureDebut);
        const end = new Date(date + 'T' + heureFin);

        // ❌ Si la date de début est dans le passé
        if (start <= now) {
            e.preventDefault();
            showErrorModal("❌ Vous ne pouvez pas réserver dans le passé.");
            return;
        }

        // ❌ Si l'heure de fin est avant l'heure de début
        if (end <= start) {
            e.preventDefault();
            showErrorModal("❌ L'heure de fin doit être après l'heure de début.");
            return;
        }
    });

    // 🔔 Fonction pour générer un message d’erreur Bootstrap
    function showErrorModal(message) {
        const modal = document.createElement("div");
        modal.classList.add("modal", "fade", "show");
        modal.style.display = "block";
        modal.innerHTML = `
            <div class="modal-dialog">
                <div class="modal-content border-danger">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title">Erreur</h5>
                    </div>
                    <div class="modal-body">
                        <p>${message}</p>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" onclick="this.closest('.modal').remove()">Fermer</button>
                    </div>
                </div>
            </div>
        `;
        document.body.appendChild(modal);
    }
</script>

<!-- 📦 Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>