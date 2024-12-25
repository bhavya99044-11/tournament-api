<?php

namespace App\Observers;

use App\Models\Order;
use Illuminate\Support\Facades\Log;
class OrderObserver
{
    /**
     * Handle the Order "created" event.
     */
    public function created(Order $order): void
    {
        // Log::info('bhavya jain here');
    }

    public function creating(Order $order){

        Log::info('bhavya jain here');

    }

    /**
     * Handle the Order "updated" event.
     */
    public function updated(Order $order): void
    {
        Log::info('bhavya jain here');
    }

    public function updating(Order $order){

       if($order->isDirty('status')){
            if($order->getOriginal('status')->value>=$order->status->value){
                return false;
            }
       }
    }
    /**
     * Handle the Order "deleted" event.
     */
    public function deleted(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "restored" event.
     */
    public function restored(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "force deleted" event.
     */
    public function forceDeleted(Order $order): void
    {
        //
    }
}
