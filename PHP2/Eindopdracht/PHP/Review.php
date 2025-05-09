<?php
require_once 'PHP/User.php';
require_once 'PHP/Product.php';
require_once 'PHP/Cart.php';
require_once 'PHP/Order.php';
require_once 'PHP/Review.php';

class Review {
    private User $user;
    private Product $product;
    private string $reviewText;

    public function __construct(User $user, Product $product, $reviewText) {
        $this->user = $user;
        $this->product = $product;
        $this->reviewText = $reviewText;
    }

    public function getReview() {
        return [
            'user' => $this->user->getName(),
            'product' => $this->product->getProductName(),
            'review' => $this->reviewText
        ];
    }
}
?>