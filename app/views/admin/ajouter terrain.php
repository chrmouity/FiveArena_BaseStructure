<?php require_once '../app/views/layouts/header.php'; ?>
<h2>Ajouter un terrain</h2>

<form action="/Admin/ajouterTerrain" method="post">
    <input type="text" name="nom" placeholder="Nom du terrain" required>
    <input type="text" name="localisation" placeholder="Localisation" required>
    <textarea name="description" placeholder="Description"></textarea>
    <button type="submit">Ajouter</button>
</form>

<?php require_once '../app/views/layouts/footer.php'; ?>
