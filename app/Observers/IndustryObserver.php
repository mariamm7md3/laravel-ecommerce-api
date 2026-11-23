<?php

namespace App\Observers;

use App\Models\Industry;

class IndustryObserver
{
    /**
     * Handle the Industry "created" event.
     */
    public function created(Industry $industry): void
    {
        //
    }

    /**
     * Handle the Industry "updated" event.
     */
    public function updated(Industry $industry): void
    {
        $industry->products->searchable();
    }

    /**
     * Handle the Industry "deleted" event.
     */
    public function deleted(Industry $industry): void
    {
        //
    }

    /**
     * Handle the Industry "restored" event.
     */
    public function restored(Industry $industry): void
    {
        //
    }

    /**
     * Handle the Industry "force deleted" event.
     */
    public function forceDeleted(Industry $industry): void
    {
        //
    }
}
