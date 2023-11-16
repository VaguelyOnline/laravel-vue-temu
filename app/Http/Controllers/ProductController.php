<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreImageRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Product::class);
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();

        // Method 1 - use the cache remember function
        $featured = Cache::remember('featured', 10* 60, function () use ($products) {
            return $products->random(3);
        });

        // Method 2 - use the individual cache functions
        /*
        if (!Cache::has('featured'))
            // Cache the recommended products for 10 minutes (10 x 60 seconds)
            Cache::put('featured', $products->random(3), 10 * 60);
        
        $featured = Cache::get('featured');
        */

        return Inertia::render('Products/ProductIndex', compact('products', 'featured'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    public function storeImage(Product $product, StoreImageRequest $request)
    {
        $request->validated();

        // Save the file to the disk
        $path = $request->file('image')->store('images');
        $url = Storage::url($path);

        // Create the model on the product images relationship
        return $product->images()->create(compact('url'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $permissions = [
            'delete' => Auth::user()->can('delete', $product),
            'update' => Auth::user()->can('update', $product)
        ];

        $product->load('images');

        return Inertia::render('Products/ProductShow', compact(
            'product',
            'permissions'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $product->load('images');
        return Inertia::render('Products/ProductEdit', compact('product'));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->validated());

        return $product;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return $product;
    }
}
