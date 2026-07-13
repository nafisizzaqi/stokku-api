<?php

namespace App\Http\Controllers\Api;

use App\Events\StockLow;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\StockTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    public function store(Request $request)
    {
        $this->authorize('create', StockTransaction::class);
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:in,out',
            'quantity' => 'required|integer|min:1',
            'note' => 'nullable|string'
        ]);

        $product = Product::findOrFail($request->product_id);
        $stock_before = $product->stock;
        if ($request->type === 'out' && $request->quantity > $stock_before) {
            return response()->json([
                'success' => false,
                'message' => 'Stock tidak cukup'
            ], 422);
        }
        $stock_after = $request->type === 'in' ? $stock_before + $request->quantity : $stock_before - $request->quantity;
        $stockTransaction = DB::transaction(function () use ($request, $product, $stock_before, $stock_after) {
            $product->update(['stock' => $stock_after]);
            return StockTransaction::create([
                'product_id'   => $request->product_id,
                'user_id'      => auth()->id(),
                'type'         => $request->type,
                'quantity'     => $request->quantity,
                'stock_before' => $stock_before,
                'stock_after'  => $stock_after,
                'note'         => $request->note
            ]);
        });
        if ($stock_after <= $product->min_stock) {
            StockLow::dispatch($stockTransaction);
        }
        return response()->json([
            'success' => true,
            'data' => $stockTransaction
        ]);
    }

    public function history()
    {
        $this->authorize('viewAny', StockTransaction::class);
        $query = StockTransaction::with(['product', 'user']);
        $stockTransactions = $query->paginate(10);
        return response()->json([
            'success' => true,
            'data' => $stockTransactions
        ]);
    }

    public function show(StockTransaction $stockTransaction)
    {
        $this->authorize('view', $stockTransaction);
        $stockTransaction->load(['product', 'user']);
        return response()->json([
            'success' => true,
            'data' => $stockTransaction
        ]);
    }
}
