<?php
class User {
    public $name;
    public $email;
    public $age;

    public function __construct($name, $email, $age) {
        $this->name = $name;
        $this->email = $email;
        $this->age = $age;
    }

    public function ShowDetails() {
        echo "De naam van de gebruiker is " . $this->name . " en is " . $this->age . " jaar oud " . " en het emailadres is " . $this->email . "<br>";
    }
}

$user1 = new user("Jan", "Janpower@gmail.com", 18);
$user1->ShowDetails();

?>