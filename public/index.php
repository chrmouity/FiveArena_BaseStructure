<?php
// Point d'entrée du projet : charge le cœur de l'application

require_once '../core/App.php';
require_once '../core/Controller.php';
require_once '../config/database.php';

// Lance l'application
$app = new App();
