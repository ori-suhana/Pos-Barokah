<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase; // PENTING: Murni PHPUnit, tidak memuat framework Laravel[cite: 6]
use App\Services\PriceCalculator;

class PriceCalculatorTest extends TestCase
{
    public function test_applies_discount(): void
    {
        $calc = new PriceCalculator();
        $result = $calc->applyDiscount(100, 10);

        // Assertion dasar untuk memastikan nilai identik[cite: 9]
        $this->assertEquals(90, $result);
    }
}