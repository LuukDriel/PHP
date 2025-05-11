<?php

class Review {
    private $user;
    private $product;
    private $text;

    public function __construct(User $user, Product $product, $text) {
        $this->user = $user;
        $this->product = $product;
        $this->text = $text;
    }

    public function getReview() {
        return "<strong>" . $this->user->getName() . "</strong> over <em>" . $this->product->getProductName() . "</em>:<br>" . htmlspecialchars($this->text);
    }
}