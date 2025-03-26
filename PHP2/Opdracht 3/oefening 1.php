<?php

class Car {
    public $brand;
    public $color;
    private $owner;

    public function __construct($brand, $color, $owner) {
        $this->brand = $brand;
        $this->color = $color;
        $this->setOwner($owner);
    }

    // Getters
    public function getOwner() {
        return $this->owner;
    }

    // Setters
    public function setOwner($owner) {
            $this->owner = $owner;
    }
    public function ShowDetails() {
        echo "Het merk van de auto is " . $this->brand . " en de kleur is " . $this->color .  "<br>";
    }

    public function isOwner() {
        if ($this->owner) {
            echo "De eigenaar van de auto is " . $this->owner . "<br>";
        } else {
            echo "De eigenaar van de auto is niet bekend.<br>";
        }
    }
}

$car1 = new Car("Audi", "Zwart", "Piet");
$car1->ShowDetails();
$car1->isOwner();

?>