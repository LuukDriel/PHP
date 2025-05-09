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

    private static function ensurePDO() {
        if (!self::$pdo && isset($GLOBALS['pdo'])) {
            self::setPDO($GLOBALS['pdo']);
        }
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

    public function __construct($name, $email, $role, $password) {
        $this->setName($name);
        $this->setEmail($email);
        $this->setRole($role);
        $this->setPassword($password);
    }

    // Setter voor wachtwoord
    public function setPassword($password) {
        $this->password = password_hash($password, PASSWORD_BCRYPT);
    }

    // Methode om gebruiker te registreren
    public function register() {
        self::ensurePDO();
        $stmt = self::$pdo->prepare("INSERT INTO users (name, email, role, password) VALUES (:name, :email, :role, :password)");
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':role', $this->role);
        $stmt->bindParam(':password', $this->password);
        return $stmt->execute();
    }

    // Methode om in te loggen
    public static function login($email, $password) {
        self::ensurePDO();
        $stmt = self::$pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return true;
        }
        return false;
    }
    
    public static function getUserId($email) {
        self::ensurePDO();
        $stmt = self::$pdo->prepare("SELECT id FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result ? $result['id'] : null;
    }

    // Methode om een gebruiker te verwijderen
    public function deleteUser($userId) {
        self::ensurePDO();
        $stmt = self::$pdo->prepare("DELETE FROM users WHERE id = :id");
        $stmt->bindParam(':id', $userId, \PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Methode om een gebruiker op te halen
    public function getUserById($userId) {
        self::ensurePDO();
        $stmt = self::$pdo->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->bindParam(':id', $userId, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    // Methode om alle gebruikers op te halen
    public function getAllUsers() {
        self::ensurePDO();
        $stmt = self::$pdo->query("SELECT * FROM users");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}

?>