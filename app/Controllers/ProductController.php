<?php
require_once __DIR__ . '/../Models/Product.php';
require_once __DIR__ . '/../Models/Category.php';  
require_once __DIR__ . '/../Models/Supplier.php';


class ProductController{
    // Récupérer tous les produits
    public function index(){
        $products = Produit::getAllProduits();
        http_response_code(200);
        echo json_encode($products);
    }

    // Récupérer un produit par son ID
    public function showById($id){
        $product = (new Produit())->getProduitById($id);
        if($product){
            http_response_code(200);
            header('Content-Type: application/json');

            echo json_encode($product);
        }else{
            http_response_code(404);
            header('Content-Type: application/json');

            echo json_encode(['error' => 'Produit non trouvé']);
        }
    }
    // Récupérer un produit par son nom
    public function searchByName($name){
        $product = (new Produit())->getProduitsForSearch($name);
        if($product){
            http_response_code(200);
            header('Content-Type: application/json');

            echo json_encode($product);
        }else{
            http_response_code(404);
            header('Content-Type: application/json');

            echo json_encode(['error' => 'Produits non trouvés']);
        }
    }

     // Récupérer un produit par son slug
    public function searchBySlug($slug){
        $product = (new Produit())->getProduitBySlug($slug);
        if($product){
            http_response_code(200);
            header('Content-Type: application/json');

            echo json_encode($product);
        }else{
            http_response_code(404);
            header('Content-Type: application/json');

            echo json_encode(['error' => 'Produit non trouvé']);
        }
    }

    // Création d'un produit
    public function create(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            try{
                $data = json_decode(file_get_contents("php://input"), true);
                $product = new Produit();
                $product->setNom_Court($data['nom_produit']);
                $product->setNom_Long($data['description_produit']);
                $product->setRef_fournisseur($data['ref_fournisseur']);
                $product->setPrix_Achat($data['prix_produit']);
                $product->setId_Categorie(Categorie::loadCategorieIdByName($data['categorie']));
                $product->setId_Fournisseur(Fournisseur::loadSupplierIdByName($data['fournisseur']));
                $product->setPhoto($data['image_produit']);
                $product->setTaux_TVA($data['taux_tva']);
    
                $product->insertProduit();
                http_response_code(201);
                header('Content-Type: application/json');

                echo json_encode(['message' => 'Produit créé avec succès']);
            } catch (Exception $e) {
                http_response_code(400);
                header('Content-Type: application/json');

                echo json_encode(['error' => $e->getMessage()]);
                return;
            }
        }
        else {
            http_response_code(405);
            header('Content-Type: application/json');

            echo json_encode(['error' => 'Méthode non autorisée']);
        }
    }

    // Modification d'un produit
    public function update($id){
        if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
            try{
                $inputData = json_decode(file_get_contents("php://input"), true);

                $product = new Produit();
                $product->loadById($id);
                $product->setNom_Court($inputData['nom_produit']);
                $product->setNom_Long($inputData['description_produit']);
                $product->setRef_fournisseur($inputData['ref_fournisseur']);
                $product->setPrix_Achat($inputData['prix_produit']);
                $product->setId_Categorie(Categorie::loadCategorieIdByName($inputData['categorie']));
                $product->setId_Fournisseur(Fournisseur::loadSupplierIdByName($inputData['fournisseur']));
                $product->setPhoto($inputData['image_produit']);
                $product->setTaux_TVA($inputData['taux_tva']);
                $product->updateProduit();
                http_response_code(200);
                header('Content-Type: application/json');

                echo json_encode(['message' => 'Produit modifié avec succès']);
            } catch (Exception $e) {
                http_response_code(400);
                header('Content-Type: application/json');

                echo json_encode(['error' => $e->getMessage()]);
                return;
            }
        }
        else {
            http_response_code(405);
            header('Content-Type: application/json');

            echo json_encode(['error' => 'Méthode non autorisée']);
        }
    }

    // Suppression d'un produit
    public function delete($id){
        if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
            try{
                $product = new Produit();
                $product->loadById($id);
                if (!$product) {
                    http_response_code(404);
                    header('Content-Type: application/json');

                    echo json_encode(['error' => 'Produit non trouvé']);
                    return;
                }
                $product->deleteProduit();
                http_response_code(200);
                header('Content-Type: application/json');

                echo json_encode(['message' => 'Produit supprimé avec succès']);
            } catch (Exception $e) {
                http_response_code(400);
                header('Content-Type: application/json');

                echo json_encode(['error' => $e->getMessage()]);
                return;
            }
        }
        else {
            http_response_code(405);
            header('Content-Type: application/json');

            echo json_encode(['error' => 'Méthode non autorisée']);
        }
    }
    


        

    

}