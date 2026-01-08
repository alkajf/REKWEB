<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProductController extends Controller
{
    private $baseUrl = 'http://localhost:8000';

    /**
     * Display a listing of products
     */
    public function index()
    {
        $products = [];
        
        $response = Http::get($this->baseUrl . '/api/Product');

        if ($response->successful()) {
            $body = $response->json();
            if (isset($body['data']) && is_array($body['data'])) {
                $products = $body['data'];
            }
        }

        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product
     */
    public function create()
    {
        $categories = [];
        
        // Fetch categories untuk dropdown
        $response = Http::get($this->baseUrl . '/api/Category');
        
        if ($response->successful()) {
            $body = $response->json();
            if (isset($body['data']) && is_array($body['data'])) {
                $categories = $body['data'];
            }
        }

        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created product
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|string',
        ]);

        $response = Http::post($this->baseUrl . '/api/Product', [
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $request->image,
        ]);

        if ($response->successful()) {
            return redirect()->route('products.index')->with('success', 'Product created successfully');
        }

        $errorMessage = $response->json('errors') 
        ?? 'Failed to create product';

        return back()->with('error', $errorMessage)->withInput();
    }

    /**
     * Show the form for editing the specified product
     */
    public function edit($id)
    {
        $product = null;
        $categories = [];

        // Fetch product detail
        $productResponse = Http::get($this->baseUrl . '/api/Product/' . $id);
        
        if ($productResponse->successful()) {
            $body = $productResponse->json();
            if (isset($body['data'])) {
                $product = $body['data'];
            }
        }

        // Fetch categories untuk dropdown
        $categoryResponse = Http::get($this->baseUrl . '/api/Category');
        
        if ($categoryResponse->successful()) {
            $body = $categoryResponse->json();
            if (isset($body['data']) && is_array($body['data'])) {
                $categories = $body['data'];
            }
        }

        if (!$product) {
            return redirect()->route('products.index')->with('error', 'Product not found');
        }

        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified product
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'category_id' => 'required',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|string',
        ]);

        $response = Http::put($this->baseUrl . '/api/Product/' . $id, [
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $request->image,
        ]);

        if ($response->successful()) {
            return redirect()->route('products.index')->with('success', 'Product updated successfully');
        }

        return back()->with('error', 'Failed to update product')->withInput();
    }

    /**
     * Remove the specified product
     */
    public function destroy($id)
    {
        $response = Http::delete($this->baseUrl . '/api/Product/' . $id);

        if ($response->successful()) {
            return redirect()->route('products.index')->with('success', 'Product deleted successfully');
        }

        return back()->with('error', 'Failed to delete product');
    }
}
