<?php
class User {
    protected $name;
    protected $email;
    private $role;
    private $password;

    public function __construct($name, $email, $role, $password = null) {
        $this->name = $name;
        $this->email = $email;
        $this->setRole($role);
        if ($password !== null) {
            $this->password = $password;
        }
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getRole() {
        return $this->role;
    }

    public function setRole($role) {
        $allowed = ['customer', 'admin'];
        if (in_array($role, $allowed)) {
            $this->role = $role;
        }
    }

    public function isAdmin() {
        return $this->role === 'admin';
    }

    public function introduce() {
        return "Naam: {$this->name}, Email: {$this->email}, Rol: {$this->role}";
    }

    // Registreer gebruiker in database
    public function register($pdo) {
        $hashedPassword = password_hash($this->password, PASSWORD_BCRYPT);
        $stmt = $pdo->prepare("INSERT INTO users (name, email, role, password) VALUES (:name, :email, :role, :password)");
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':role', $this->role);
        $stmt->bindParam(':password', $hashedPassword);
        return $stmt->execute();
    }
}

class AdminUser extends User {
    private $permissions = [];

    public function __construct($name, $email, $role, $password = null, $permissions = []) {
        parent::__construct($name, $email, $role, $password);
        $this->permissions = $permissions;
    }

    public function getPermissions() {
        return $this->permissions;
    }

    public function setPermissions($permissions) {
        $this->permissions = $permissions;
    }
}
?>