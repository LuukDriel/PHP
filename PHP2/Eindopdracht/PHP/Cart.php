<?php
require_once 'PHP/User.php';
require_once 'PHP/Product.php';
require_once 'PHP/Cart.php';
require_once 'PHP/Order.php';
require_once 'PHP/Review.php';

class Cart {
    private array $products = [];

    public function addProduct(Product $product) {
        $this->products[] = $product;
    }

    public function removeProduct(Product $product) {
        foreach ($this->products as $key => $p) {
            if ($p->getProductName() === $product->getProductName()) {
                unset($this->products[$key]);
                break;
            }
        }
    }

    public function getCartDetails() {
        $details = [];
        foreach ($this->products as $product) {
            $details[] = [
                'name' => $product->getProductName(),
                'price' => $product->getPrice()
            ];
        }
        return $details;
    }
}
?>