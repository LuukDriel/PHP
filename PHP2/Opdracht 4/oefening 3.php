<?php
class User {
    // Privé eigenschappen
    private $name;
    private $email;
    private $role; // Nieuwe eigenschap voor rol
    private $dateofbirth; // Nieuwe eigenschap voor geboortedatum

    // Constructor om eigenschappen in te stellen
    public function __construct($name, $dateofbirth, $email, $role) {
        $this->name = $name;
        $this->dateofbirth = $dateofbirth; // Huidige datum als standaard geboortedatum
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

    // Getter voor geboortedatum
    public function getdateofbirth() {
        return $this->dateofbirth;
    }

    // Setter voor geboortedatum
    public function setdateofbirth($dateofbirth) {
        $date = DateTime::createFromFormat('d-m-Y', $dateofbirth);
        if ($date && $date->format('d-m-Y') === $dateofbirth) {
            $this->dateofbirth = $dateofbirth;
        } else {
            echo "Ongeldige geboortedatum.<br>";
        }
    }

    // Methode om de gebruiker te introduceren
    public function introduce() {
        echo "Hallo, mijn naam is " . $this->getName() . ", Mijn geboortedatum is " . $this->getdateofbirth() . " en mijn e-mail is " . $this->getEmail() . ". Mijn rol is " . $this->getRole() . ".<br>";
    }
}

class AdminUser extends User {
    // Eigenschap voor permissies
    private $permissions;

    // Constructor om de AdminUser te initialiseren
    public function __construct($name, $dateofbirth, $email, $role, $permissions) {
        // Roep de constructor van de User-klasse aan
        parent::__construct($name, $dateofbirth, $email, $role);

        // Stel de permissies in
        $this->permissions = $permissions;
    }

    // Methode om de permissies te tonen
    public function displayPermissions() {
        echo "Permissies van admin " . $this->getName() . ": " . implode(", ", $this->permissions) . ".<br>";
    }

    // Getter voor permissies
    public function getPermissions() {
        return $this->permissions;
    }

    // Setter voor permissies
    public function setPermissions($permissions) {
        if (is_array($permissions)) {
            $this->permissions = $permissions;
        } else {
            echo "Permissies moeten een array zijn.<br>";
        }
    }
}

// Aanmaken van een object en gebruik maken van getters en setters

$user1 = new User("Pieter piet", "05-05-2000", "piet@example.com", "user"); 
$user1->introduce();

$admin1 = new AdminUser("Admin Jansen", "01-01-2000", "admin@example.com", "admin", ["manage_users", "view_reports"]);
$admin1->introduce();
$admin1->displayPermissions();
