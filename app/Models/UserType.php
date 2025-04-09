<?php
require_once __DIR__ . '/../../config/database.php';

class UserType
{
    private $id;
    private $libelle;

    public function getId() { return $this->id; }
    public function getLibelle() { return $this->libelle; }

    public function setId($id) { $this->id = $id; }
    public function setLibelle($libelle) { $this->libelle = $libelle; }

    public static function getUserTypeById($id) {
        $dao = new database();
        return $dao->select('t_d_usertype', 'Id_UserType = :id', [':id' => $id], '','', 'UserType')[0] ?? null;
    }

    public static function getUserTypeByName($libelle) {
        $dao = new database();
        return $dao->select('t_d_usertype', 'Libelle = :lib', [':lib' => $libelle], '','', 'UserType')[0] ?? null;
    }


    public static function loadLibelleById($id)
    {
        $params = array(
            ':id' => $id
        );

        $dao = new database();
        if (!empty($nom)) {
            $usertype = $dao->select("t_d_usertype", "Id_UserType = :id", $params, "Id_UserType")[0] ?? null;
            return $usertype['Libelle'] ?? null;
      }
        else{
            return null;
        }
        
    }
}
?>
