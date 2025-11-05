<?php

namespace App\Services;

use App\Models\Product;
use Carbon\Carbon;

class DynamicPricingService
{
    public function calculateDynamicPrice(Product $product)
    {
        $totalStock = $product->stock()->sum('quantity');
        $now = Carbon::now();

        $basePrice = $product->base_price;
        $finalPrice = $basePrice;

        // Rule 1: Stock level adjustments
        if ($totalStock < 10) {
            $finalPrice *= 1.30; // +30%
        } elseif ($totalStock >= 10 && $totalStock <= 50) {
            $finalPrice *= 1.10; // +10%
        } elseif ($totalStock > 100) {
            $finalPrice *= 0.80; // -20%
        }

        // Rule 2: Expiring soon discount
        $nearExpiry = $product->stock()
            ->where('expires_at', '<', $now->copy()->addDays(7))
            ->sum('quantity');

        if ($nearExpiry > 0) {
            $discountPerUnit = 0.25 * $basePrice; // 25% off
            $discountRatio = $nearExpiry / max($totalStock, 1);
            $finalPrice -= $discountRatio * $discountPerUnit;
        }

        return round($finalPrice, 2);
    }
}
