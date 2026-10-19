<?php

namespace App\Services; // Namespace harus sesuai

class PriceCalculator
{
    public function applyDiscount(float $price, float $discountPercentage): float
    {
        return $price - ($price * ($discountPercentage / 100));
    }
}