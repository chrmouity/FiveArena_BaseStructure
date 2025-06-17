<?php
/**
 * Classe Database
 * Gère la connexion PDO à la base de données fivearena
 */

class Database {
    // Informations de connexion
    private static $host = 'localhost';
    private static $dbName = 'fivearena'; // nom de ta base de données
    private static $username = 'root';    // utilisateur local par défaut
    private static $password = '';        // mot de passe vide si tu es sur WAMP/XAMPP local
    private static $pdo = null;           // objet PDO statique

    // Méthode statique pour obtenir une connexion
    public static function connect() {
        if (self::$pdo === null) {
            try {
                // Connexion à la base de données avec PDO
                self::$pdo = new PDO(
                    'mysql:host=' . self::$host . ';dbname=' . self::$dbName . ';charset=utf8',
                    self::$username,
                    self::$password
                );
                // Déclenche une exception si une erreur SQL survient
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                // En cas d’erreur, arrêter le script et afficher un message
                die('❌ Erreur de connexion à la base de données : ' . $e->getMessage());
            }
        }
        return self::$pdo;
    }
}
?>
