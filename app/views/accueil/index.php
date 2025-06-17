<?php require_once '../app/views/layouts/header.php'; ?>

<h2>Bienvenue sur FiveArena</h2>
<p>Réservez vos terrains de football simplement et rapidement.</p>

<?php if (!isset($_SESSION['user'])): ?>
    <p><a href="/Auth/index">Connexion</a> | <a href="/Auth/register">Inscription</a></p>
<?php else: ?>
    <p><a href="/Reservation/index">Faire une réservation</a></p>
<?php endif; ?>

<?php require_once '../app/views/layouts/footer.php'; ?>
