<?php
class User {
    // Privé eigenschappen
    private $name;
    private $email;
    private $role; // Nieuwe eigenschap voor rol

    // Constructor om eigenschappen in te stellen
    public function __construct($name, $email, $role) {
        $this->name = $name;
        $this->email = $email;
        $this->setRole($role); // Rol instellen via setter
    }

    // Getter voor naam
    public function getName() {
        return $this->name;
    }

    // Setter voor naam
    public function setName($name) {
        if (strlen($name) > 0) {
            $this->name = $name;
        } else {
            echo "Naam kan niet leeg zijn.<br>";
        }
    }

    // Getter voor email
    public function getEmail() {
        return $this->email;
    }

    // Setter voor email
    public function setEmail($email) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->email = $email;
        } else {
            echo "Ongeldig e-mailadres.<br>";
        }
    }

    // Getter voor rol
    public function getRole() {
        return $this->role;
    }

    // Setter voor rol
    public function setRole($role) {
        $validRoles = ['admin', 'user']; // Alleen 'admin' en 'user' zijn geldig
        if (in_array($role, $validRoles)) {
            $this->role = $role;
        } else {
            echo "Ongeldige rol.<br>";
        }
    }

    // Methode om te controleren of de rol 'admin' is
    public function isAdmin() {
        return $this->role === 'admin';
    }

    // Methode om de gebruiker te introduceren
    public function introduce() {
        echo "Hallo, mijn naam is " . $this->getName() . " en mijn e-mail is " . $this->getEmail() . ". Mijn rol is " . $this->getRole() . ".<br>";
    }
}

// Aanmaken van een object en gebruik maken van getters en setters
$user1 = new User("Jan Jansen", "jan@example.com", "user");
$user1->introduce();

// Veranderen van de rol naar 'admin'
$user1->setRole("admin");
$user1->introduce();

// Controleren of de gebruiker admin is
if ($user1->isAdmin()) {
    echo $user1->getName() . " is een admin.<br>";
} else {
    echo $user1->getName() . " is geen admin.<br>";
}
?>
