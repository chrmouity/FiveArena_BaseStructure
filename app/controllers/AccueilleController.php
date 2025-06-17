<?php
// Contrôleur de la page d'accueil

class AccueilController extends Controller {
    public function index() {
        $this->view('accueil/index');
    }
}
