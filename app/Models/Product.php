<?php
require_once __DIR__ . '/../../config/database.php';


class Produit
{
    private $dao;
    private $Id_Produit;
    private $Taux_TVA;
    private $Nom_Long;
    private $Nom_court;
    private $Ref_fournisseur;
    private $Photo;
    private $Prix_Achat;
    private $Id_Fournisseur;
    private $Id_Categorie;
    private $Slug;

    public function __construct()
    {
        $this->dao = new database();
    }

    // Getters
    public function getId_Produit()
    {
        return $this->Id_Produit;
    }
    public function getTaux_TVA()
    {
        return $this->Taux_TVA;
    }
    public function getNom_Long()
    {
        return $this->Nom_Long;
    }
    public function getNom_court()
    {
        return $this->Nom_court;
    }
    public function getRef_fournisseur()
    {
        return $this->Ref_fournisseur;
    }
    public function getPhoto()
    {
        return $this->Photo;
    }
    public function getPrix_Achat()
    {
        return $this->Prix_Achat;
    }
    public function getId_Fournisseur()
    {
        return $this->Id_Fournisseur;
    }
    public function getId_Categorie()
    {
        return $this->Id_Categorie;
    }
    public function getSlug()
    {
        return $this->Slug;
    }


    public function getPrixTTC()
    {
        return ($this->getPrix_Achat() + ($this->getPrix_Achat() * $this->getTaux_TVA() / 100));
    }

    // Setters
    public function setId_Produit($id)
    {
        $this->Id_Produit = $id;
    }
    public function setTaux_TVA($tauxtva)
    {
        $this->Taux_TVA = $tauxtva;
    }
    public function setNom_Long($nomlong)
    {
        $this->Nom_Long = $nomlong;
    }
    public function setNom_Court($nomcourt)
    {
        $this->Nom_court = $nomcourt;
    }
    public function setRef_fournisseur($reffr)
    {
        $this->Ref_fournisseur = $reffr;
    }
    public function setPhoto($photo)
    {
        $this->Photo = $photo;
    }
    public function setPrix_Achat($prix)
    {
        $this->Prix_Achat = $prix;
    }
    public function setId_Fournisseur($idfournisseur)
    {
        $this->Id_Fournisseur = $idfournisseur;
    }
    public function setId_Categorie($idcat)
    {
        $this->Id_Categorie = $idcat;
    }
    public function setSlug($slug)
    {
        $this->Slug = $slug;
    }

    /*Fonctions BDD*/

    public function getProduitById($id)
    {
        $params = array(
            ':id' => $id
        );
        return $this->dao->select("t_d_produit", "id_produit = :id", $params)[0] ?? null;
    }

    public function loadById($id)
    {
        $produit = $this->dao->select("t_d_produit", "Id_Produit = :id", [':id' => $id], "","", "Produit")[0] ?? null;
        if ($produit) {
            $this->Id_Produit = $produit->getId_Produit();
            $this->Nom_court = $produit->getNom_Court();
            $this->Nom_Long = $produit->getNom_Long();
            $this->Ref_fournisseur = $produit->getRef_fournisseur();
            $this->Prix_Achat = $produit->getPrix_Achat();
            $this->Id_Categorie = $produit->getId_Categorie();
            $this->Id_Fournisseur = $produit->getId_Fournisseur();
            $this->Photo = $produit->getPhoto();
            $this->Taux_TVA = $produit->getTaux_TVA();
        }
    }

    public function getProduitBySlug($slug)
    {
        $params = array(
            ':slug' => $slug
        );
        return $this->dao->select("t_d_produit", "Slug = :slug", $params, '', '')[0] ?? null;
    }

    public function getProduitsForSearch($search)
    {
        $params = array(':search' => "%$search%");
        return $this->dao->select("t_d_produit", "Nom_court like :search", $params, "Nom_court", "");
    }

    public static function getAllProduits()
    {
        $params = array();
        $dao = new database();
        return $dao->select("t_d_produit", "", $params, "Nom_court", "");
    }

    public function insertProduit()
    {

        $values = array(
            'Taux_TVA' => $this->Taux_TVA,
            'Nom_Long' => $this->Nom_Long,
            'Nom_court' => $this->Nom_court,
            'Ref_fournisseur' => $this->Ref_fournisseur,
            'Photo' => $this->Photo,
            'Prix_Achat' => $this->Prix_Achat,
            'Id_Fournisseur' => $this->Id_Fournisseur,
            'Id_Categorie' => $this->Id_Categorie
        );

        return $this->dao->insert('t_d_produit', $values);
    }

    public function updateProduit()
    {
        $data = array(
            'Taux_TVA' => $this->Taux_TVA,
            'Nom_Long' => $this->Nom_Long,
            'Nom_court' => $this->Nom_court,
            'Ref_fournisseur' => $this->Ref_fournisseur,
            'Photo' => $this->Photo,
            'Prix_Achat' => $this->Prix_Achat,
            'Id_Fournisseur' => $this->Id_Fournisseur,
            'Id_Categorie' => $this->Id_Categorie,
        );
        // Condition de mise à jour
        $where = 'Id_Produit = ?';
        $params = [$this->Id_Produit]; // ID du produit à mettre à jour
        return $this->dao->update('t_d_produit', $data, $where, $params);
    }

    public function deleteProduit()
    {

        $where = 'Id_Produit = ?';
        $params = [$this->Id_Produit]; // ID du produit à mettre à jour

        return $this->dao->delete('t_d_produit', $where, $params);
    }
    /*Fin fonctions BDD*/
}
