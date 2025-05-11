<?php
require_once 'PHP/User.php';
require_once 'PHP/Product.php';
require_once 'PHP/Cart.php';
require_once 'PHP/Order.php';
require_once 'PHP/Review.php';

class Product {
    protected string $productName;
    protected float $price;

    public function __construct($productName, $price) {
        $this->setProductName($productName);
        $this->setPrice($price);
    }

    public function getProductName() { return $this->productName; }
    public function setProductName($productName) { $this->productName = $productName; }

    public function getPrice() { return $this->price; }
    public function setPrice($price) { $this->price = (float)$price; }
}

class AdminProduct extends Product {
    public function updateProductDetails($productName, $price) {
        $this->setProductName($productName);
        $this->setPrice($price);
    }
}
?>