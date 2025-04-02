<?php

class Vehicle {
    protected $model;

    public function __construct($model) {
        $this->model = $model;
    }
}

class Car extends Vehicle {
    private $NumberOfDoors;

    public function __construct($model, $numberOfDoors) {
        parent::__construct($model);
        $this->NumberOfDoors = $numberOfDoors;
    }

    public function descripe() {
        return "Model: {$this->model}, Number of Doors: {$this->NumberOfDoors}<br>";
    }
}

class Bike extends Vehicle {
    private $type;

    public function __construct($model, $type) {
        parent::__construct($model);
        $this->type = $type;
    }

    public function descripe() {
        return "Model: {$this->model}, Type: {$this->type}<br>";
    }
}

$car1 = new Car("Toyota Corolla", 4);
echo $car1 ->descripe();

$bike1 = new Bike("Giant", "Mountain");
echo $bike1 ->descripe();

?>