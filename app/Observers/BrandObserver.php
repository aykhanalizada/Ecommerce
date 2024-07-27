<?php

namespace App\Observers;

use App\Models\Brand;
use Illuminate\Support\Facades\Cache;

class BrandObserver
{
    private function clearCache()
    {
        Cache::forget('brands');
    }

    /**
     * Handle the Brand "created" event.
     */
    public function created(Brand $brand): void
    {
        $this->clearCache();
    }

    /**
     * Handle the Brand "updated" event.
     */
    public function updated(Brand $brand): void
    {
        $this->clearCache();

    }

    /**
     * Handle the Brand "deleted" event.
     */
    public function deleted(Brand $brand): void
    {
        $this->clearCache();

    }

    /**
     * Handle the Brand "restored" event.
     */
    public function restored(Brand $brand): void
    {
        //
    }

    /**
     * Handle the Brand "force deleted" event.
     */
    public function forceDeleted(Brand $brand): void
    {
        //
    }
}
