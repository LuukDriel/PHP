<?php
require_once 'PHP/User.php';
require_once 'PHP/Product.php';
require_once 'PHP/Cart.php';
require_once 'PHP/Order.php';
require_once 'PHP/Review.php';

class Order {
    private User $user;
    private array $products = [];

    public function __construct(User $user) {
        $this->user = $user;
    }

    public function addProduct(Product $product) {
        $this->products[] = $product;
    }

    public function getOrderDetails() {
        $details = [
            'user' => $this->user->introduce(),
            'products' => []
        ];
        foreach ($this->products as $product) {
            $details['products'][] = [
                'name' => $product->getProductName(),
                'price' => $product->getPrice()
            ];
        }
        return $details;
    }
}
?>