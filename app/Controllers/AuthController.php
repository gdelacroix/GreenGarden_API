<?php

require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/../Models/UserType.php';

class AuthController
{
    // Récupérer tous les utilisateurs
    public function index()
    {
        $users = User::getAllUsers();
        http_response_code(200);
        echo json_encode($users);
    }

    // Récupérer un utilisateur par ID
    public function showById($id)
    {
        $user = (new User())->getUtilisateurById($id);
        if ($user) {
            http_response_code(200);
            echo json_encode($user);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Utilisateur non trouvé']);
        }
    }

    // Récupérer un utilisateur par login
    public function getByLogin($login)
    {
        return (new User())->getUtilisateurByLogin($login);
    }

    // Inscription d'un utilisateur
    public function inscription()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents("php://input"), true);
            $login = $data['login'] ?? null;
            $password = $data['password'] ?? null;

            if (!$login || !$password) {
                http_response_code(400);
                echo json_encode(['error' => 'Login et mot de passe requis']);
                return;
            }

            $user = $this->getByLogin($login);

            if ($user) {
                http_response_code(409);
                echo json_encode(['error' => 'Ce login est déjà utilisé']);
                return;
            }

            $user = new User();
            $user->setLogin($login);
            $user->setPassword($password); // Hachage du mot de passe
            $user->insertUtilisateur();

            http_response_code(201);
            echo json_encode(['message' => 'Inscription réussie']);
        } else {
            http_response_code(405);
            echo json_encode(['error' => 'Méthode non autorisée']);
        }
    }

    // Connexion d'un utilisateur
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents("php://input"), true);
            $login = $data['login'] ?? null;
            $password = $data['password'] ?? null;

            if (!$login || !$password) {
                http_response_code(400);
                echo json_encode(['error' => 'Login et mot de passe requis']);
                return;
            }

            $user = (new User())->getUtilisateurByLogin($login);

            if ($user && password_verify($password, $user->getPassword())) {
                session_start();
                $_SESSION['user_id'] = $user->getId_User();
                $_SESSION['user_type'] = UserType::getUserTypeById($user->getId_UserType())->getLibelle();
                $_SESSION['logged_in'] = true;

                http_response_code(200);
                echo json_encode([
                    'message' => 'Connexion réussie',
                    'user_id' => $_SESSION['user_id'],
                    'user_type' => $_SESSION['user_type']
                ]);
            } else {
                http_response_code(401);
                echo json_encode(['error' => 'Identifiants incorrects']);
            }
        } else {
            http_response_code(405);
            echo json_encode(['error' => 'Méthode non autorisée']);
        }
    }
}
