<?php

class Order {
    private $user;
    private $products = [];

    public function __construct(User $user) {
        $this->user = $user;
    }

    public function addProduct(Product $product) {
        $this->products[] = $product;
    }

    public function getOrderDetails() {
        $details = "Bestelling voor: " . $this->user->getName() . "<br>Producten:<ul>";
        foreach ($this->products as $product) {
            $details .= "<li>" . $product->getProductName() . " - €" . number_format($product->getPrice(), 2) . "</li>";
        }
        $details .= "</ul>";
        return $details;
    }
}