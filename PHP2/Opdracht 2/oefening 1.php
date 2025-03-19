<?php 
class Car {
    public $brand;
    public $color;

    public function __construct($brand, $color) {
        $this->brand = $brand;
        $this->color = $color;
    }

    public function ShowDetails() {
        echo "Het merk van de auto is " . $this->brand . " en de kleur is " . $this->color . "<br>";
    }
}

$car1 = new Car("Audi", "Zwart");
$car1->ShowDetails();

$car2 = new Car("BMW", "Blauw");
$car2->ShowDetails();