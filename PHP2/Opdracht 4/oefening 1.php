<?php

class Product {
    protected $productName;
    protected $price;

    public function __construct($productName, $price) {
        $this->productName = $productName;
        $this->price = $price;
    }
}

class Book extends Product {
    private $author;

    public function __construct($productName, $price, $author) {
        parent::__construct($productName, $price);
        $this->author = $author;
    }

    public function getDetails() {
        return "Product: {$this->productName}, Price: {$this->price}, Author: {$this->author}";
    }
}

$newBook = new Book("PHP Programming", 29.99, "John Doe");
echo $newBook->getDetails();

?>