<?php

namespace App\Listeners;

use App\Events\StockLow;
use App\Models\User;
use App\Notifications\LowStockNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

class SendLowStockAlert implements ShouldQueue
{
    /**
     * Handle the event.
     */
    public function handle(StockLow $event): void
    {
        $users = User::where('role', 'admin')->get();
        Notification::send($users, new LowStockNotification($event->transaction));
    }
}
