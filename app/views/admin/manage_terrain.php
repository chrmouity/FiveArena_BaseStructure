<?php require_once '../app/views/layouts/header.php'; ?>

<!-- 🔧 Titre de la section -->
<h2 class="text-center mb-4">⚒ Gestion des Réservations</h2>

<!-- ✅ Message de succès si une réservation a été annulée -->
<?php if (isset($_GET['deleted'])): ?>
    <div class="alert alert-success text-center">✅ Réservation annulée avec succès.</div>
<?php endif; ?>

<!-- ✉️ Message si un email de confirmation a été envoyé -->
<?php if (isset($_GET['confirmed'])): ?>
    <div class="alert alert-info text-center">✉️ Email de confirmation envoyé.</div>
<?php endif; ?>

<!-- 📋 Tableau des réservations -->
<?php if (!empty($data['reservations'])): ?>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Utilisateur</th>
                <th>Email</th>
                <th>Terrain</th>
                <th>Localisation</th>
                <th>Date</th>
                <th>Début</th>
                <th>Fin</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data['reservations'] as $resa): ?>
                <tr class="<?= $resa['notified'] == 0 ? 'table-warning' : '' ?>">
                    <td><?= htmlspecialchars($resa['username']) ?></td>
                    <td><?= htmlspecialchars($resa['email']) ?></td>
                    <td><?= htmlspecialchars($resa['terrain_nom']) ?></td>
                    <td><?= htmlspecialchars($resa['localisation']) ?></td>
                    <td><?= htmlspecialchars($resa['date']) ?></td>
                    <td><?= htmlspecialchars($resa['heure_debut']) ?></td>
                    <td><?= htmlspecialchars($resa['heure_fin']) ?></td>
                    <td class="d-flex gap-1">
                        <!-- ❌ Bouton pour annuler une réservation -->
                        <a href="/FiveArena_BaseStructure/public/Admin/supprimer/<?= $resa['id'] ?>"
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Voulez-vous vraiment annuler cette réservation ?');">
                           Annuler
                        </a>

                        <!-- ✅ Bouton pour envoyer l'email de confirmation -->
                        <?php if ($resa['notified'] == 0): ?>
                            <a href="/FiveArena_BaseStructure/public/Admin/confirmerReservation/<?= $resa['id'] ?>"
                               class="btn btn-success btn-sm"
                               onclick="return confirm('Envoyer un email de confirmation à l’utilisateur ?');">
                               Confirmer par mail
                            </a>
                        <?php else: ?>
                            <!-- Badge si déjà confirmé -->
                            <span class="badge bg-success">Confirmée</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p class="text-center">Aucune réservation enregistrée.</p>
<?php endif; ?>

<?php require_once '../app/views/layouts/footer.php'; ?>
