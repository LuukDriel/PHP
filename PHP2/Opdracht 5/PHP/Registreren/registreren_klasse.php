<?php
include '../DB_Con.php';

class Registreren {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function registerUser($name, $password, $email) {
        // Check if username already exists
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE name = :name");
        $stmt->execute([$name]);
        if ($stmt->rowCount() > 0) {
            return "Username Bestaat al.";
        }

        // Check if email already exists
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute([$email]);
        if ($stmt->rowCount() > 0) {
            return "Email Bestaat al.";
        }

        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert new user into the database
        $stmt = $this->pdo->prepare("INSERT INTO users (name, password, email) VALUES (:name, :password, :email)");
        if ($stmt->execute([$name, $hashedPassword, $email])) {
            return "Registratie Gelukt!";
        } else {
            return "Registratie Mislukt.";
        }
    }
}