<!-- app/views/auth/login.php -->

<?php require_once '../app/views/layouts/header.php'; ?> 
<!-- Inclut l’en-tête du site (menu, balises HTML, etc.) -->

<h2 class="text-center">Connexion</h2>

<!-- Formulaire de connexion -->
<form action="/FiveArena_BaseStructure/public/Auth/index" method="post">
    
    <!-- Champ de saisie de l'email -->
    <div class="mb-3">
        <label for="email" class="form-label">Email :</label>
        <!-- name="email" est important car il est récupéré en PHP dans $_POST['email'] -->
        <input type="text" name="email" id="email" class="form-control" required placeholder="Votre adresse email">
    </div>

    <!-- Champ de saisie du mot de passe -->
    <div class="mb-3">
        <label for="password" class="form-label">Mot de passe :</label>
        <!-- name="password" est aussi récupéré en PHP dans $_POST['password'] -->
        <input type="password" name="password" id="password" class="form-control" required placeholder="Votre mot de passe">
    </div>

    <!-- Bouton pour soumettre le formulaire -->
    <div class="d-grid">
        <button type="submit" class="btn btn-primary">Se connecter</button>
    </div>
</form>

<!-- Lien vers l'inscription pour les nouveaux utilisateurs -->
<p class="mt-3 text-center">
    Pas encore inscrit ? 
    <a href="/FiveArena_BaseStructure/public/Auth/register">Créer un compte</a>
</p>

<?php require_once '../app/views/layouts/footer.php'; ?>
<!-- Inclut le pied de page (mention copyright, scripts) -->
