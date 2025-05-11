<?php
require_once 'User.php';

// Maak een gewone gebruiker aan
$user = new User('Jan', 'jan@email.com', 'user');
echo $user->introduce(); // Output: Naam: Jan, Email: jan@email.com, Rol: user

// Maak een admin gebruiker aan
$admin = new AdminUser('Admin', 'admin@email.com', 'admin', ['producten_beheren', 'gebruikers_beheren']);
echo $admin->introduce(); // Output: Naam: Admin, Email: admin@email.com, Rol: admin

// Controleer of iemand admin is
if ($admin->isAdmin()) {
    echo "Deze gebruiker is een admin.<br>";
}

// Admin permissies tonen
echo "Permissies: " . implode(', ', $admin->getPermissions());
?>