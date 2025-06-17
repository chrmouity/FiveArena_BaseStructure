<?php
// ✅ Démarrage sécurisé de la session si elle n’est pas déjà lancée
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>FiveArena</title>
    <!-- ✅ Inclusion de Bootstrap pour le style -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- ✅ Lien vers la feuille de style personnalisée -->
    <link rel="stylesheet" href="/FiveArena_BaseStructure/public/assets/css/style.css">
</head>
<body>

<!-- 🧾 EN-TÊTE DU SITE -->
<header class="bg-primary text-white py-3">
    <div class="container d-flex justify-content-between align-items-center">
        <!-- 🔹 Nom de l’application -->
        <h1 class="h4 m-0">FiveArena – Réservation de terrains de football</h1>

        <!-- 👤 Message de bienvenue si l'utilisateur est connecté -->
        <?php if (isset($_SESSION['user'])): ?>
            <div>
                👋 Bienvenue, <strong><?= htmlspecialchars($_SESSION['user']['username']) ?></strong>
            </div>
        <?php endif; ?>
    </div>

    <!-- 🔗 Barre de navigation -->
    <nav class="mt-2">
        <ul class="nav justify-content-center">
            <?php if (isset($_SESSION['user'])): ?>
                <!-- Liens accessibles à tous les utilisateurs connectés -->
                <li class="nav-item">
                    <a class="nav-link text-white" href="/FiveArena_BaseStructure/public/Reservation/index">Réserver</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="/FiveArena_BaseStructure/public/Reservation/mesReservations">Mes Réservations</a>
                </li>

                <!-- 🔐 Accès spécial pour l’administrateur -->
                <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="/FiveArena_BaseStructure/public/Admin/index">Admin</a>
                    </li>
                <?php endif; ?>

                <!-- 🔓 Lien pour se déconnecter -->
                <li class="nav-item">
                    <a class="nav-link text-white" href="/FiveArena_BaseStructure/public/Auth/logout">Déconnexion</a>
                </li>

            <?php else: ?>
                <!-- 🔐 Liens affichés uniquement si l’utilisateur n’est pas connecté -->
                <li class="nav-item">
                    <a class="nav-link text-white" href="/FiveArena_BaseStructure/public/Auth/index">Connexion</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="/FiveArena_BaseStructure/public/Auth/register">Inscription</a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</header>

<!-- ⬇️ Début du contenu principal de la page -->
<main class="container mt-4">
