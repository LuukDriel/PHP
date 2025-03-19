<?php

class Boek {
    public $titel;
    public $auteur;
    public $jaar;

    public function __construct($titel, $auteur, $jaar) {
    $this->titel = $titel;
    $this->auteur = $auteur;
    $this->jaar = $jaar;
    }

    public function ShowDetails() {
        echo "Het boek " . $this->titel . " is geschreven door " . $this->auteur . " in het jaar " . $this->jaar . "<br>";
    }
}

$boek1 = new Boek("De Hobbit", "J.R.R. Tolkien", 1937);
$boek1->ShowDetails();

?>