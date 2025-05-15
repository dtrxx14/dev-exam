<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::paginate(10);

        return response()->json($products, 201);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        try {
            DB::beginTransaction();

            // Validate request data
            $validated = $request->validated();

            // Generate product_code based on name
            $name = trim($validated['name']);
            $first = strtoupper(substr($name, 0, 1));
            $last = strtoupper(substr($name, -1));

            // Count existing products to generate next incremental number
            $count = Product::count() + 1;
            $number = str_pad($count, 10, '0', STR_PAD_LEFT);

            // Create the product_code
            $validated['product_code'] = $first . $number . $last;

            // Create the product record
            $product = Product::create($validated);

            DB::commit();

            return response()->json($product, 201);
        } catch (\Throwable $th) {
            DB::rollback();
            Log::error($th);
            return response()->json(['error' => 'Failed to create product.'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return response()->json($product, 201);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $product->update($request->only('name', 'description', 'price'));
        return $product;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return response()->noContent();
    }
}
