<?php

require_once __DIR__ . '/../Models/Supplier.php';

class SupplierController
{
    // Récupérer tous les fournisseurs
    public function index()
    {
        $suppliers = Fournisseur::getAllFournisseurs();
        header("Content-Type: application/json");  // Envoi des en-têtes d'abord
        http_response_code(200);
        echo json_encode($suppliers);
    }

    // Récupérer un fournisseur par son ID
    public function showById($id)
    {
        $supplier = (new Fournisseur())->getFournisseurById($id);
        if ($supplier) {
            // Si le fournisseur est trouvé, on renvoie les données du fournisseur
            header("Content-Type: application/json");  // Envoi des en-têtes d'abord
            http_response_code(200);
            echo json_encode($supplier);
        } else {
            // Si le fournisseur n'est pas trouvé, on renvoie une erreur 404
            header("Content-Type: application/json");  // Envoi des en-têtes d'abord
            http_response_code(404);
            echo json_encode(['error' => 'Fournisseur non trouvé']);
        }
    }
}
