<?php

require_once __DIR__ . '/../Models/Category.php';

class CategoryController{

    // Récupérer toutes les catégories
    public function index(){
        $categories = Categorie::getAllCategories();
        http_response_code(200);
        echo json_encode($categories);
    }

    // Récupérer une catégorie par son ID
    public function showById($id){
        $category = (new Categorie())->getCategorieById($id);
        if($category){
            http_response_code(200);
            header('Content-Type: application/json');
            echo json_encode($category);
        }else{
            http_response_code(404);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Catégorie non trouvée']);
        }
    }
}

?>