<?php
include_once '../DB_Con.php';

class Inlog {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function login($name, $password) {
        $sql = "SELECT * FROM users WHERE name = :name";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            if (isset($user['role'])) {
                $_SESSION['role'] = $user['role'];
            }
            return true;
        } else {
            return false;
        }
    }

    public function isIngelogd() {
        session_start();
        return isset($_SESSION['name']);
    }

    public function uitloggen() {
        session_start();
        session_unset();
        session_destroy();
    }

    // Controleer of de ingelogde gebruiker admin is
    public function isAdmin() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        // Controleer of er een rol in de sessie staat en of deze 'admin' is
        return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
    }
}
?>