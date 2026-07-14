<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\ExportStockReport;
use App\Models\Product;
use Dotenv\Repository\RepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    public function lowStock()
    {
        $this->authorize('viewAny', Product::class);

        $products = Cache::remember('report.low_stock', 600, function () {
            return Product::with(['category', 'supplier'])
                ->whereColumn('stock', '<=', 'min_stock')
                ->get();
        });

        return response()->json([
            'success' => true,
            'data' => $products,
        ]);
    }

    public function export()
    {
        $this->authorize('viewAny', Product::class);
        ExportStockReport::dispatch(auth()->id());
        return response()->json([
            'success' => true,
            'message' => 'Export sedang di proses'
        ], 202);
    }

    public function download()
    {
        $this->authorize('viewAny', Product::class);

        $files = Storage::files('exports');

        if (empty($files)) {
            return response()->json(['success' => false, 'message' => 'File tidak ditemukan'], 404);
        }

        usort($files, fn($a, $b) => Storage::lastModified($b) <=> Storage::lastModified($a));

        return Storage::download($files[0]);
    }
}
