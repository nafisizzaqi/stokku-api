<?php

namespace App\Providers;

use App\Events\StockLow;
use App\Listeners\SendLowStockAlert;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        StockLow::class => [
            SendLowStockAlert::class
        ]
    ];
}
