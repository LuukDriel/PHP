<?php

class User {
    protected string $name;
    protected string $email;
    private string $role;

    public function __construct($name, $email, $role = 'user') {
        $this->setName($name);
        $this->setEmail($email);
        $this->setRole($role);
    }

    public function getName() { return $this->name; }
    public function setName($name) { $this->name = $name; }

    public function getEmail() { return $this->email; }
    public function setEmail($email) { $this->email = $email; }

    public function getRole() { return $this->role; }
    public function setRole($role) {
        if (in_array($role, ['user', 'admin'])) {
            $this->role = $role;
        } else {
            throw new Exception("Ongeldige rol");
        }
    }

    public function isAdmin() { return $this->role === 'admin'; }

    public function introduce() {
        return "Naam: {$this->name}, Email: {$this->email}, Rol: {$this->role}";
    }
}

class AdminUser extends User {
    private array $permissions;

    public function __construct($name, $email, $role = 'admin', $permissions = []) {
        parent::__construct($name, $email, $role);
        $this->setPermissions($permissions);
    }

    public function getPermissions() { return $this->permissions; }
    public function setPermissions($permissions) { $this->permissions = $permissions; }
}
?>