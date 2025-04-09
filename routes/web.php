<?php
require_once __DIR__ . '/../app/Controllers/ProductController.php';
require_once __DIR__ . '/../app/Controllers/AuthController.php';
require_once __DIR__ . '/../app/Controllers/CategoryController.php';
require_once __DIR__ . '/../app/Controllers/SupplierController.php';
$productController = new ProductController();
$authController = new AuthController();
$categoryController = new CategoryController();
$supplierController = new SupplierController();

header("Content-Type: application/json");

$request_method = $_SERVER['REQUEST_METHOD'];


// Récupérer l'URL de la requête
$url = $_SERVER['REQUEST_URI'];

// Séparer l'URL en chemin et paramètres de requête
$parsed_url = parse_url($url);
$route = trim($parsed_url['path'], '/'); // Récupérer le chemin sans les slashs
$uri = explode('/', trim($_SERVER['REQUEST_URI'], '/'));

$id = isset($_GET['id']) ? (int)$_GET['id'] : null;

switch ($request_method) {
    case 'GET':
        switch ($route) {
            case 'categories':
                if ($id) {
                    $categoryController->showById($id);
                } else {
                    $categoryController->index();
                }
                break;
            case 'suppliers':
                if ($id) {
                    $supplierController->showById($id);
                } else {
                    $supplierController->index();
                }
                break;
            case 'users':
                if ($id) {
                    $authController->showById($id);
                } elseif (isset($_GET['login'])) {
                    $user = $authController->getByLogin($_GET['login']);
                    if ($user) {
                        http_response_code(200);
                        echo json_encode($user);
                    } else {
                        http_response_code(404);
                        echo json_encode(['error' => 'Utilisateur non trouvé']);
                    }
                } else {
                    $authController->index();
                }
                break;
            case 'products':
                if ($id) {
                    $productController->showById($id);
                } else {
                    $productController->index();
                }
                break;
            case 'product-search':
                    if (isset($_GET['name'])) {
                        $productController->searchByName($_GET['name']);
                    } else {
                        http_response_code(400);
                        echo json_encode(['error' => 'Nom de produit requis']);
                    }
                    break;
            case 'product-slug':
                    if (isset($_GET['slug'])) {
                        $productController->searchBySlug($_GET['slug']);
                    } else {
                        http_response_code(400);
                        echo json_encode(['error' => 'Slug de produit requis']);
                    }
                    break;
            default:
                http_response_code(404);
                echo json_encode(['error' => 'Route non trouvée']);
                break;
        }
        break;
    case 'POST':
       switch ($route) {
            case 'login':
                $authController->login();
                break;
            case 'register':
                $authController->inscription();
                break;
            case 'products':
                $productController->create();
                break;
            default:
                http_response_code(404);
                echo json_encode(['error' => 'Route non trouvée']);
                break;
        }
        break;
    case 'PUT':
        if ($route === 'products' && $id) {
            $productController->update($id);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Route non trouvée']);
        }
        break;
    case 'DELETE':
        if ($route === 'products' && $id) {
            $productController->delete($id);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Route non trouvée']);
        }
        break;
    default:
        http_response_code(405);
        echo json_encode(['error' => 'Méthode non autorisée']);
        break;
}