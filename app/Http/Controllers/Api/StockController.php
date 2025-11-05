<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\Product;

class StockController extends Controller
{
  
    public function store(Request $request)
    {
        
        $validated = $request->validate([
            'pr_id' => 'required|exists:products,pr_id',
            'wh_id' => 'required|integer',
            'quantity' => 'required|integer|min:0',
            'expires_at' => 'nullable|date',
        ]);
       
        

       
        $stock = Stock::updateOrCreate(
            [
                'pr_id' => $validated['pr_id'],
                'wh_id' => $validated['wh_id']
            ],
            [
                'quantity' => $validated['quantity'],
                'expires_at' => $validated['expires_at'] ?? null,
                'status' => 1
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Stock record created or updated successfully',
            'data' => $stock
        ]);
    }
}
