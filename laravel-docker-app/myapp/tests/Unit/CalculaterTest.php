<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class PriceCalculaterTest extends TestCase
{
    private \App\Services\PriceCalculater $calculator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->calculator = new \App\Services\PriceCalculater();
    }

    // ===== 正常系 =====

    public function test_calculate_total_without_tax(): void
    {
        $result = $this->calculator->calculateTotal(100, 2, 0);
        $this->assertEquals(200, $result);
    }

    public function test_calculate_total_with_tax(): void
    {
        $result = $this->calculator->calculateTotal(100, 2, 0.1);
        $this->assertEquals(220, $result);
    }

    public function test_apply_discount(): void
    {
        $result = $this->calculator->applyDiscount(1000, 20);
        $this->assertEquals(800, $result);
    }

    // ===== 異常系 =====

    public function test_calculate_total_throws_exception_for_negative_price(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Price and quantity must be non-negative');

        $this->calculator->calculateTotal(-100, 2, 0);
    }

    public function test_calculate_total_throws_exception_for_negative_quantity(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Price and quantity must be non-negative');

        $this->calculator->calculateTotal(100, -2, 0);
    }

    public function test_apply_discount_throws_exception_for_negative_percent(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Discount must be between 0 and 100');

        $this->calculator->applyDiscount(1000, -10);
    }

    public function test_apply_discount_throws_exception_for_percent_over_100(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Discount must be between 0 and 100');

        $this->calculator->applyDiscount(1000, 150);
    }

    // ===== 境界値 =====

    public function test_calculate_total_with_zero_quantity(): void
    {
        $result = $this->calculator->calculateTotal(100, 0, 0.1);
        $this->assertEquals(0, $result);
    }

    public function test_calculate_total_with_zero_price(): void
    {
        $result = $this->calculator->calculateTotal(0, 5, 0.1);
        $this->assertEquals(0, $result);
    }

    public function test_apply_discount_with_zero_percent_boundary(): void
    {
        // 0%は許可される境界値
        $result = $this->calculator->applyDiscount(1000, 0);
        $this->assertEquals(1000, $result);
    }

    public function test_apply_discount_with_hundred_percent_boundary(): void
    {
        // 100%は許可される境界値
        $result = $this->calculator->applyDiscount(1000, 100);
        $this->assertEquals(0, $result);
    }
}