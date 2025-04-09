<?php
require_once 'config.php';

class Database {
    private $db_host;
    private $db_name;
    private $db_user;
    private $db_password;
    private $pdo;

    public function __construct()
    {
        try {
            // Récupération des paramètres depuis config.php
            $env = 'dev'; // ou 'prod' à changer lors de la conteneurisation
          
            // $this->db_host =  constant('DB_HOST_' . strtoupper($env));;
            $this->db_host =  "db";

            $this->db_name = constant('DB_NAME');;
            $this->db_user =  constant('DB_USER_' . strtoupper($env));;
            $this->db_password =  constant('DB_PASSWORD_' . strtoupper($env));;

            // Connexion à la base de données
            $dsn = "mysql:host={$this->db_host};dbname={$this->db_name};charset=utf8mb4";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            $this->pdo = new PDO($dsn, $this->db_user, $this->db_password, $options);
        } catch (PDOException $e) {
            die("Erreur de connexion à la base de données : " . $e->getMessage());
        }
    }

    public function getConnection()
    {
        return $this->pdo;
    }

    public function select($table, $where = '', $params = [], $order_by = '', $limit = '', $class = '')
    {
        try {
            $sql = "SELECT * FROM $table";
            if (!empty($where)) $sql .= " WHERE $where";
            if (!empty($order_by)) $sql .= " ORDER BY $order_by";
            if (!empty($limit)) $sql .= " LIMIT $limit";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);

            return (!empty($class)) ? $stmt->fetchAll(PDO::FETCH_CLASS, $class) : $stmt->fetchAll();
        } catch (PDOException $e) {
            die("Erreur SELECT : " . $e->getMessage());
        }
    }

    public function insert($table, $data)
    {
        try {
            $keys = array_keys($data);
            $values = array_values($data);
            $placeholders = implode(',', array_fill(0, count($values), '?'));

            $sql = "INSERT INTO $table (" . implode(',', $keys) . ") VALUES ($placeholders)";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute($values);
        } catch (PDOException $e) {
            die("Erreur INSERT : " . $e->getMessage());
        }
    }

    public function update($table, $data, $where = '', $params = [])
    {
        try {
            $set_values = implode(',', array_map(fn($key) => "$key = ?", array_keys($data)));
            $sql = "UPDATE $table SET $set_values";
            if (!empty($where)) $sql .= " WHERE $where";
            
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute(array_merge(array_values($data), $params));
        } catch (PDOException $e) {
            die("Erreur UPDATE : " . $e->getMessage());
        }
    }

    public function delete($table, $where = '', $params = [])
    {
        try {
            $sql = "DELETE FROM $table";
            if (!empty($where)) $sql .= " WHERE $where";
            
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            die("Erreur DELETE : " . $e->getMessage());
        }
    }
}
?>