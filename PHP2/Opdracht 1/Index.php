<?php 
class Car {
    public $brand;
    public $color;

    public function ShowDetails() {
        echo "Het merk van de auto is " . $this->brand . " en de kleur is " . $this->color . "<br>";
    }
}

$car1 = new Car();
$car1->brand = "Audi";
$car1->color = "Zwart";
$car1->ShowDetails();

class User {
    public $name;
    public $email;
    public $age;

    public function ShowDetails() {
        echo "De naam van de gebruiker is " . $this->name . " en is " . $this->age . " jaar oud " . " en het emailadres is " . $this->email . "<br>";
    }
}

$user1 = new User();
$user1->name = "Jan";
$user1->email = "janpower200@gmail.com";
$user1->age = 18;
$user1->ShowDetails();

$user2 = new User();
$user2->name = "Piet";
$user2->email = "piet@gmail.com";
$user2->age = 20;
$user2->ShowDetails();

$user3 = new User();
$user3->name = "Klaas";
$user3->email = "Klaas@gmail.com";
$user3->age = 22;
$user3->ShowDetails();

?>
