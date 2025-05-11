<?php

class Product {
    protected $productName;
    protected $price;

    public function __construct($productName, $price) {
        $this->productName = $productName;
        $this->price = $price;
    }

    public function getProductName() { return $this->productName; }
    public function setProductName($productName) { $this->productName = $productName; }
    public function getPrice() { return $this->price; }
    public function setPrice($price) { $this->price = $price; }
}

class AdminProduct extends Product {
    public function updateProductDetails($productName, $price) {
        $this->setProductName($productName);
        $this->setPrice($price);
    }
}