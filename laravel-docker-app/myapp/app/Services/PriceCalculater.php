<?php

namespace App\Services;

class PriceCalculater
{
    public function calculateTotal(int $price, int $quantity, float $taxRate)
    {
        if ($price < 0 || $quantity < 0) {
            throw new \InvalidArgumentException('Price and quantity must be non-negative');
        }

        $subtotal = $price * $quantity;
        $tax = $subtotal * $taxRate;

        return (int) ($subtotal + $tax);
    }

    public function applyDiscount(int $price, int $discountPercent)
    {
        if($discountPercent < 0 || $discountPercent > 100) {
            throw new \InvalidArgumentException('Discount must be between 0 and 100');
        }

        $discount = $price * ($discountPercent / 100);
        return $price - $discount;
    }
}