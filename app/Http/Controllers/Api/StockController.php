<?php

namespace App\Http\Controllers\Api;

use App\Events\StockLow;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\StockTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StockController extends Controller
{
    public function store(Request $request)
    {
        $this->authorize('create', StockTransaction::class);
        $request->validate([
            'product_id' => 'required|exists:products,id,deleted_at,NULL',
            'type' => 'required|in:in,out',
            'quantity' => 'required|integer|min:1',
            'note' => 'nullable|string'
        ]);

        $stockTransaction = DB::transaction(function () use ($request) {
            $product = Product::lockForUpdate()->findOrFail($request->product_id);
            $stock_before = $product->stock;
            if ($request->type === 'out' && $request->quantity > $stock_before) {
                abort(422, 'Stock tidak cukup');
            }
            $stock_after = $request->type === 'in' ? $stock_before + $request->quantity : $stock_before - $request->quantity;
            $product->update(['stock' => $stock_after]);
            $stockTransaction = StockTransaction::create([
                'product_id'   => $request->product_id,
                'user_id'      => auth()->id(),
                'type'         => $request->type,
                'quantity'     => $request->quantity,
                'stock_before' => $stock_before,
                'stock_after'  => $stock_after,
                'note'         => $request->note
            ]);
            if ($stock_after <= $product->min_stock) {
                DB::afterCommit(fn() => StockLow::dispatch($stockTransaction));
            }
            return $stockTransaction;
        });
        Log::channel('daily')->info('[TRANSACTION] ' . " product_id={$stockTransaction->product_id} " . " type={$stockTransaction->type} " . " qty={$stockTransaction->quantity} " . " by=user_id={$stockTransaction->user_id} ");
        Cache::forget('report.low_stock');
        return response()->json([
            'success' => true,
            'data' => $stockTransaction->load(['product', 'user'])
        ], 201);
    }

    public function history(Request $request)
    {
        $this->authorize('viewAny', StockTransaction::class);
        $query = StockTransaction::with(['product', 'user']);
        if ($request->product_id) {
            $query->where('product_id', $request->product_id);
        }
        $stockTransactions = $query->paginate(10);
        return response()->json([
            'success' => true,
            'data' => $stockTransactions
        ]);
    }
}
