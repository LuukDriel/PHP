<?php

class Cart {
    private $products = [];

    public function addProduct(Product $product) {
        $this->products[] = $product;
    }

    public function removeProduct(Product $product) {
        foreach ($this->products as $i => $p) {
            if ($p->getProductName() === $product->getProductName()) {
                unset($this->products[$i]);
                break;
            }
        }
        $this->products = array_values($this->products);
    }

    public function getCartDetails() {
        $details = "<ul>";
        foreach ($this->products as $product) {
            $details .= "<li>" . $product->getProductName() . " - €" . number_format($product->getPrice(), 2) . "</li>";
        }
        $details .= "</ul>";
        return $details;
    }
}