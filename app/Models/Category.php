<?php
require_once __DIR__ . '/../../config/database.php';

class Categorie
{
    private $dao;
    private $Id_Categorie;
    private $Libelle;
    private $Slug;

    public function __construct($id_categorie = null, $libelle = null)
    {
        $this->dao = new database();
        $this->Id_Categorie = $id_categorie;
        $this->Libelle = $libelle;
    }

     // Getters
     public function getId_Categorie() {
        return $this->Id_Categorie;
    }

    public function getLibelle() {
        return $this->Libelle;
    }
    public function getSlug() { return $this->Slug; }

    // Setters
    public function setId_Categorie($id_categorie) {
        $this->Id_Categorie = $id_categorie;
    }

    public function setLibelle($libelle) {
        $this->Libelle = $libelle;
    }
    public function setSlug($slug) { $this->Slug = $slug; }

    public function getCategorieById($id)
    {
        $params = array(
            ':id' => $id
        );
        return $this->dao->select("t_d_categorie", "id_categorie = :id", $params,"","")[0]?? null;
    }

    public function getCategorieBySlug($slug)
    {
        $params = array(
            ':slug' => $slug
        );
        return $this->dao->select("t_d_categorie", "Slug = :slug", $params,"","")[0]?? null;
    }

   
    public static function loadCategorieIdByName($libelle)
    {
        $params = array(
            ':libelle' => $libelle
        );
        $dao = new database();
        if (!empty($libelle)) {
            $categorie = $dao->select("t_d_categorie", "Libelle = :libelle", $params, "Id_Categorie",)[0] ?? null;
            return $categorie['Id_Categorie'] ?? null;
        }
        else{
            return null;
        }
        
    }

    public static function getAllCategories($search = '')
    {
        $params = array();
        $dao = new database();
        if (!empty($search)) {
            $params = array(
                ':slug' => $search
            );
            $categories = $dao->select("t_d_categorie", "Slug = :slug", $params, "Libelle","");

        }
        else{
            $categories = $dao->select("t_d_categorie", "", $params, "Libelle","");

        }
       
        return $categories;
    }

}
