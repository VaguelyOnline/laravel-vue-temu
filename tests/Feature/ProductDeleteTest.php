<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductDeleteTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh');
        $this->artisan('db:seed');
    }

    public function test_auth(): void
    {
        $admin = User::where('email', 'admin@temu.com')->first();
        $user = User::where('email', 'user@temu.com')->first();

        $product = Product::all()->random();

        # Those without admin role cannot delete
        $this->actingAs($user)
            ->delete(route('api.products.images.delete', [$product->id, $product->images->first()->id]))
            ->assertStatus(403);

        # Those with admin role can delete
        $this->actingAs($admin)
            ->delete(route('api.products.images.delete', [$product->id, $product->images->first()->id]))
            ->assertStatus(200);
    }

    public function test_image_belongsto_product(): void
    {
        $admin = User::where('email', 'admin@temu.com')->first();

        $product1 = Product::all()->random();
        $product2 = Product::all()->random();

        while($product1 === $product2) {
            $product2 = Product::all()->random();
        }

        # Check image must belong to product
        $this->actingAs($admin)
            ->delete(route('api.products.images.delete', [$product1->id, $product2->images->first()->id]))
            ->assertStatus(403);
    }
}
