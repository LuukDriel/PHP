<?php
include_once '../DB_Con.php';
class Account
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Haal gebruikersdata op
    public function Getuserdata($userId)
    {
        $query = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Haal bestellingsdata op
    public function Getbestellingdata($userId)
    {
        $query = "SELECT * FROM orders WHERE user_id = :user_id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Verwijder een gebruiker
    public function VerwijderUser($userId)
    {
        $query = "DELETE FROM users WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Update gebruikersdata
    public function UpdateUser($userId, $data)
    {
        $query = "UPDATE users SET name = :name, email = :email, password = :password WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':password', $data['password']);
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Update gebruikersdata
    public function UpdateUserFromPost($userId, $postData)
    {
        $user = $this->Getuserdata($userId);
        $updateData = [
            'name' => trim($postData['name']),
            'email' => trim($postData['email']),
            'password' => !empty($postData['password']) ? password_hash($postData['password'], PASSWORD_DEFAULT) : $user['password']
        ];
        return $this->UpdateUser($userId, $updateData);
    }
}
?>