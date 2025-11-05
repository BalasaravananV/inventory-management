<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;  
use App\Models\Product;
use App\Services\DynamicPricingService;

class ProductController extends Controller
{
    protected $pricingService;

    public function __construct(DynamicPricingService $pricingService)
    {
        $this->pricingService = $pricingService;
    }

    public function index()
    {
        $products = Product::with('stock')->get();

        $data = $products->map(function ($product) {
            return [
                'id' => $product->pr_id,
                'name' => $product->pr_name,
                'base_price' => $product->base_price,
                'dynamic_price' => app(DynamicPricingService::class)->calculateDynamicPrice($product),
                'total_stock' => $product->stock->sum('quantity'),
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

  public function store(Request $request)
    {
        
        $validated = $request->validate([
            'pr_name' => 'required|string|max:255',
            'base_price' => 'required|numeric|min:0',
            // 'quantity' => 'required|integer|min:1',
        ]);

        
        $product = Product::create([
            'pr_name' => $validated['pr_name'],
            'base_price' => $validated['base_price'],
            // 'quantity' => $validated['quantity'],
            'status' => 1, 
        ]);

        
        return response()->json([
            'success' => true,
            'message' => 'Product added successfully!',
            'data' => $product
        ]);
    }
}
