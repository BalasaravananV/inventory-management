<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Warehouse;
use Carbon\Carbon;

class WarehouseController extends Controller
{
    public function report($id)
    {
       
        $warehouse = Warehouse::with(['stock.product'])->find($id);        
        // print_r($warehouse);
        // exit;
        
        if (!$warehouse) {
            return response()->json([
                'success' => false,
                'message' => 'Warehouse not found',
            ], 404);
        }

        $now = Carbon::now();
        $next7Days = $now->copy()->addDays(7);

        $report = $warehouse->stock->map(function ($stock) use ($next7Days) {
            $isNearExpiry = $stock->expires_at && $stock->expires_at <= $next7Days;

            return [
                'product_id' => $stock->product->pr_id,
                'product_name' => $stock->product->pr_name,
                'quantity' => $stock->quantity,
                'expires_at' => $stock->expires_at,
                'near_expiry' => $isNearExpiry,
            ];
        });

        return response()->json([
            'success' => true,
            'warehouse_id' => $warehouse->wh_id,
            'warehouse_name' => $warehouse->name ?? 'Unknown',
            'data' => $report,
        ]);
    }

      public function store(Request $request)
    {
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
           'latitude' => 'required|numeric|between:-90,90',
    'longitude' => 'required|numeric|between:-180,180',
            'status' => 'nullable|boolean',
        ]);

        
        $warehouse = Warehouse::create([
            'name' => $validated['name'],
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
            'status' => $validated['status'] ?? 1,
        ]);

      
        return response()->json([
            'success' => true,
            'message' => 'Warehouse created successfully!',
            'data' => $warehouse
        ], 201);
    }

}
