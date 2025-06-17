<?php
class AuthController extends Controller {

    // Page de connexion
    public function index() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $userModel = $this->model('User');
            $user = $userModel->findByEmail($email);

            if ($user && password_verify($password, $user['password'])) {
                session_start();
                $_SESSION['user'] = $user;

                // Redirection selon le rôle
                if ($user['role'] === 'admin') {
                    header('Location: /FiveArena_BaseStructure/public/Admin/index');
                } else {
                    header('Location: /FiveArena_BaseStructure/public/Reservation/index');
                }
                exit;
            } else {
                echo "❌ Identifiants incorrects.";
            }
        } else {
            $this->view('auth/login');
        }
    }

    // Page d'inscription
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $confirm = $_POST['confirm_password'];

            if ($password !== $confirm) {
                echo "❌ Les mots de passe ne correspondent pas.";
                return;
            }

            if (!preg_match('/^(?=.*[A-Z])(?=.*\d).{8,}$/', $password)) {
                echo "❌ Le mot de passe doit contenir au moins 8 caractères, une majuscule et un chiffre.";
                return;
            }

            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            $userModel = $this->model('User');
            $userModel->register($username, $email, $hashedPassword);

            header('Location: /FiveArena_BaseStructure/public/Auth/index');
            exit;
        } else {
            $this->view('auth/register');
        }
    }

    // Déconnexion
   public function logout() {
    session_start();
    session_destroy();
    header('Location: /FiveArena_BaseStructure/public/Auth/index');
    exit;
}
}