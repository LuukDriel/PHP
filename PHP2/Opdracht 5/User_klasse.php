<?php

class User {
    protected $name;
    protected $email;
    private $role;
    private $password;

    public function __construct($name, $email, $role, $password) {
        $this->setName($name);
        $this->setEmail($email);
        $this->setRole($role);
        $this->setPassword($password);
    }

    // Getter en setter voor naam
    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        if (!empty($name)) {
            $this->name = $name;
        } else {
            throw new \Exception("Naam mag niet leeg zijn.");
        }
    }

    // Getter en setter voor email
    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->email = $email;
        } else {
            throw new \Exception("Ongeldig e-mailadres.");
        }
    }

    // Getter en setter voor rol
    public function getRole() {
        return $this->role;
    }

    public function setRole($role) {
        $validRoles = ['admin', 'user'];
        if (in_array($role, $validRoles)) {
            $this->role = $role;
        } else {
            throw new \Exception("Ongeldige rol. Alleen 'admin' of 'user' toegestaan.");
        }
    }

    // Setter voor wachtwoord
    public function setPassword($password) {
        if (!empty($password)) {
            $this->password = password_hash($password, PASSWORD_BCRYPT);
        } else {
            throw new \Exception("Wachtwoord mag niet leeg zijn.");
        }
    }

    // Methode om gebruiker te registreren
    public function register($pdo) {
        $stmt = $pdo->prepare("INSERT INTO users (name, email, role, password) VALUES (:name, :email, :role, :password)");
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':role', $this->role);
        $stmt->bindParam(':password', $this->password);
        return $stmt->execute();
    }

    // Methode om in te loggen
    public function login($pdo) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $this->email);
        $stmt->execute();
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($user && password_verify($this->password, $user['password'])) {
            return true;
        } else {
            return false;
        }
    }
}

try {
    $pdo = new PDO('mysql:host=localhost;dbname=winkel', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $user1 = new User("Piet Pieter", "Piet.Pieter@googler.com", "user", "Piet1234");
    if ($user1->register($pdo)) {
        echo "Registratie succesvol!<br>";
    } else {
        echo "Registratie mislukt.<br>";
    }

    $userlogin = new User("Piet Pieter", "Piet.Pieter@googler.com", "user", "Piet1234");
    if ($userlogin->login($pdo)) {
        echo "Inloggen succesvol! Welkom, " . $userlogin->getName() . "!<br>";
    } else {
        echo "Inloggen mislukt. Controleer uw e-mailadres en wachtwoord.<br>";
    }

} catch (PDOException $e) {
    echo "Databasefout: " . $e->getMessage() . "<br>";
} catch (\Exception $e) {
    echo "Fout: " . $e->getMessage() . "<br>";
}

?>