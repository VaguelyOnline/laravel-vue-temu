<?php

namespace App\Observers;

use App\Models\Product;
use App\Models\Audit;

class ProductObserver
{
    /**
     * Handle the Product "created" event.
     */
    public function created(Product $product): void
    {
        Audit::create([
            // 'user_id'=>1, When seeding product creation does not have a user id - thus set user_id to one when seeding then back to user id thereafter.

            'user_id'=>auth()->id(),
            'action_type'=>'created',
            'affected_product_id'=>$product->id,
        ]);
    }

    /**
     * Handle the Product "updated" event.
     */
    public function updated(Product $product): void
    {
        Audit::create([
            'user_id'=>auth()->id(),
            'action_type'=>'updated',
            'affected_product_id'=>$product->id,
        ]);
    }

    /**
     * Handle the Product "deleted" event.
     */
    public function deleted(Product $product): void
    {
        Audit::create([
            'user_id'=>auth()->id(),
            'action_type'=>'deleted',
            'affected_product_id'=>$product->id,
        ]);
    }

    /**
     * Handle the Product "restored" event.
     */
    public function restored(Product $product): void
    {
        //
    }

    /**
     * Handle the Product "force deleted" event.
     */
    public function forceDeleted(Product $product): void
    {
        //
    }
}
