<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CategoryController extends Controller
{
    private $baseUrl = 'http://localhost:8000';

    /**
     * Display a listing of categories
     */
    public function index()
    {
        $categories = [];

        $response = Http::get($this->baseUrl . '/api/Category');

        if ($response->successful()) {
            $body = $response->json();
            if (isset($body['data']) && is_array($body['data'])) {
                $categories = $body['data'];
            }
        }

        return view('home.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category
     */
    public function create()
    {
        return view('home.create');
    }

    /**
     * Store a newly created category
     */
    public function store(Request $request)
    {
        $request->validate([
            'id' => 'nullable|integer',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $response = Http::post($this->baseUrl . '/api/Category', [
            'id' => $request->id,
            'name' => $request->name,
            'description' => $request->description,
        ]);

        if ($response->successful()) {
            return redirect()->route('home.index')->with('success', 'Category created successfully');
        }

        $errorMessage = $response->json('errors') 
        ?? 'Failed to create category';

        return back()->with('error', $errorMessage)->withInput();
    }

    /**
     * Show the form for editing the specified category
     */
    public function edit($id)
    {
        $category = null;

        $response = Http::get($this->baseUrl . '/api/Category/' . $id);
        
        if ($response->successful()) {
            $body = $response->json();
            if (isset($body['data'])) {
                $category = $body['data'];
            }
        }

        if (!$category) {
            return redirect()->route('home.index')->with('error', 'Category not found');
        }

        return view('home.edit', compact('category'));
    }

    /**
     * Update the specified category
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $response = Http::put($this->baseUrl . '/api/Category/' . $id, [
            'name' => $request->name,
            'description' => $request->description,
        ]);

        if ($response->successful()) {
            return redirect()->route('home.index')->with('success', 'Category updated successfully');
        }

        return back()->with('error', 'Failed to update category')->withInput();
    }

    /**
     * Remove the specified category
     */
    public function destroy($id)
    {
        $response = Http::delete($this->baseUrl . '/api/Category/' . $id);

        if ($response->successful()) {
            return redirect()->route('home.index')->with('success', 'Category deleted successfully');
        }

        return back()->with('error', 'Failed to delete category');
    }
}
