<?php

namespace App\Events;

use App\Models\StockTransaction;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StockLow
{
    use Dispatchable, SerializesModels;

    public function __construct(public StockTransaction $transaction){}
}
