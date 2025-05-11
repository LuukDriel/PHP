<?php
include_once '../DB_connect.php';
class User {
    protected $name;
    protected $email;
    private $role;
    private $password;
    private static $pdo;

    public static function setPDO($pdo) {
        self::$pdo = $pdo;
    }

    public function __construct($name, $email, $role, $password) {
        $this->setName($name);
        $this->setEmail($email);
        $this->setRole($role);
        $this->setPassword($password);
    }

    public function setName($name) {
        $this->name = $name;
    }

public function setEmail($email) {
        $this->email = $email;
    }
    public function setRole($role) {
        $this->role = $role;
    }

    // Setter voor wachtwoord
    public function setPassword($password) {
            $this->password = password_hash($password, PASSWORD_BCRYPT);
    }

    // Methode om gebruiker te registreren
    public function register() {
        $stmt = self::$pdo->prepare("INSERT INTO users (name, email, role, password) VALUES (:name, :email, :role, :password)");
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':role', $this->role);
        $stmt->bindParam(':password', $this->password);
        return $stmt->execute();
    }

    // Methode om in te loggen
    public static function login($email, $password) {
        $stmt = self::$pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return true;
        }
        return false;
    }
        

    // Methode om een gebruiker te verwijderen
    public function deleteUser($userId) {
        $stmt = self::$pdo->prepare("DELETE FROM users WHERE id = :id");
        $stmt->bindParam(':id', $userId, \PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Methode om een gebruiker bij te werken
    public function updateUser($userId, $name, $email, $role, $password = null) {
        $sql = "UPDATE users SET name = :name, email = :email, role = :role";
        if ($password) {
            $sql .= ", password = :password";
        }
        $sql .= " WHERE id = :id";

        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':id', $userId, \PDO::PARAM_INT);

        if ($password) {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $stmt->bindParam(':password', $hashedPassword);
        }

        return $stmt->execute();
    }

    // Methode om een gebruiker op te halen
    public function getUserById($userId) {
        $stmt = self::$pdo->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->bindParam(':id', $userId, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    // Methode om alle gebruikers op te halen
    public function getAllUsers() {
        $stmt = self::$pdo->query("SELECT * FROM users");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}

?>