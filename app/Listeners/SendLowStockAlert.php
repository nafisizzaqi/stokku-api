<?php

namespace App\Listeners;

use App\Events\StockLow;
use App\Mail\LowStockNotification;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendLowStockAlert implements ShouldQueue
{
    /**
     * Handle the event.
     */
    public function handle(StockLow $event): void
    {
        $users = User::where('role', 'admin')->get();
        foreach ($users as $user) {
            Mail::to($user->email)->send(new LowStockNotification($event->stock));
        }
    }
}
