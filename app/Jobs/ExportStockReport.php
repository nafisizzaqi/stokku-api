<?php

namespace App\Jobs;

use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class ExportStockReport implements ShouldQueue
{
    use Queueable, Dispatchable, InteractsWithQueue, SerializesModels;

    public $timeout = 120;
    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $fileName = 'product_report_' . time() . '.csv';
        $filePath = 'exports/' . $fileName;

        if (!Storage::exists('exports')) {
            Storage::makeDirectory('exports');
        }

        $file = fopen(Storage::path($filePath), 'w');

        fputcsv($file, ['Name', 'Sku', 'Price', 'Stock']);

        Product::chunk(1000, function($products) use ($file){
            foreach ($products as $product) {
                fputcsv($file, [
                    $product->name,
                    $product->sku,
                    $product->price,
                    $product->stock,
                ]);
            }
        });

        fclose($file);
    }
}
