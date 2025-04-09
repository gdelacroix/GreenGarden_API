<?php
require_once __DIR__ . '/../../config/database.php';

class User
{
    private $dao;
    private $Id_User;
    private $Id_UserType;
    private $Login;
    private $Password;
    public function __construct()
    {
        $this->dao = new database();
    }

    // Getters
    /**
     * Get the value of Id_User
     */
    public function getId_User()
    {
        return $this->Id_User;
    }
    /**
     * Get the value of Id_UserType
     */
    public function getId_UserType()
    {
        return $this->Id_UserType;
    }
    /**
     * Get the value of Login
     */
    public function getLogin()
    {
        return $this->Login;
    }

    /**
     * Get the value of Password
     */
    public function getPassword()
    {
        return $this->Password;
    }

    // Setters
    /**
     * Set the value of Id_User
     *
     * @return  self
     */
    public function setId_User($Id_User)
    {
        $this->Id_User = $Id_User;

        return $this;
    }



    /**
     * Set the value of Id_UserType
     *
     * @return  self
     */
    public function setId_UserType($Id_UserType)
    {
        $this->Id_UserType = $Id_UserType;

        return $this;
    }


    /**
     * Set the value of Login
     *
     * @return  self
     */
    public function setLogin($Login)
    {
        $this->Login = $Login;

        return $this;
    }



    /**
     * Set the value of Password
     *
     * @return  self
     */
    public function setPassword($Password)
    {
        $this->Password = $Password;

        return $this;
    }
    // Récupérer tous les utilisateurs
    public static function getAllUsers()
    {
        $params = array();
        $dao = new database();
        $utilisateurs =  $dao->select("t_d_user", "", $params, "Login", "");

        return $utilisateurs;
    }

    // Récupérer un utilisateur par ID
    public function getUtilisateurById($id)
    {
        $params = array(
            ':id' => $id
        );
        return $this->dao->select("t_d_user", "Id_User = :id", $params, "", "");
    }

    // Récupérer un utilisateur par Login
    public function getUtilisateurByLogin($login)
    {
        $params = array(
            ':login' => $login
        );
        $result = $this->dao->select("t_d_user", "Login = :login", $params, "","", "User");
        return $result[0] ?? null;
    }

    public function insertUtilisateur()
    {
        $values = array(
            'id_usertype' => 1,
            'Login' => $this->Login,
            'Password' => password_hash($this->Password, PASSWORD_DEFAULT)

        );
        return $this->dao->insert('t_d_user', $values);
    }
}
