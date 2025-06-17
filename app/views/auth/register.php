<?php require_once '../app/views/layouts/header.php'; ?>

<h2>Inscription</h2>

<form action="/FiveArena_BaseStructure/public/Auth/register" method="post">
    <input type="text" name="username" placeholder="Nom d'utilisateur" required>
    <input type="email" name="email" placeholder="Email" required>

    <input type="password" name="password" placeholder="Mot de passe" required>
    <input type="password" name="confirm_password" placeholder="Confirmez le mot de passe" required>

    <button type="submit">S'inscrire</button>
</form>

<p>Déjà inscrit ? <a href="/Auth/index">Se connecter</a></p>

<!-- Appel JS -->
<script src="/assets/js/register.js"></script>

<?php require_once '../app/views/layouts/footer.php'; ?>
