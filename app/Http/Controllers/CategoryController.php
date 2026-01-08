<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str; // Tambahkan import untuk helper Str

class CategoryController extends Controller
{
    /**
     * GET /api/categories
     * Return list kategori.
     */
    public function index(): JsonResponse
    {
        $categories = Category::orderBy('created_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'message' => 'List categories retrieved successfully',
            'data' => $categories,
        ], 200);
    }
    
    /**
     * POST /api/categories
     * Menyimpan kategori baru.
     * * Perbaikan: Memastikan kolom 'slug' dibuat otomatis dan dimasukkan ke database 
     * untuk mencegah SQLSTATE error 500.
     */
    public function store(Request $request): JsonResponse
    {
        // Ambil semua data dari request
        $data = $request->all();

        // --- VALIDASI DATA ---

        // Validasi ID (Wajib diisi, maks 255 karakter)
        if (empty($data['id'])) {
            return $this->validationErrorResponse('ID must be filled');
        }
        if (strlen($data['id']) > 255) {
            return $this->validationErrorResponse('ID may not be greater than 255 characters.'); 
        }

        // Validasi Name (Wajib diisi, maks 255 karakter)
        if (empty($data['name'])) {
            // FIX: Memperbaiki typo 'Reuired' menjadi 'Required'
            return $this->validationErrorResponse('Name is Required'); 
        }
        if (strlen($data['name']) > 255) {
           return $this->validationErrorResponse('Name may not be greater than 255 characters.'); 
        }

        // Cek ID Unik
        if (Category::where('id', $data['id'])->exists()) {
           return $this->validationErrorResponse('ID already exists.'); 
        }

        // --- PERBAIKAN UTAMA: PEMBUATAN SLUG OTOMATIS ---
        
        // 1. Membuat slug awal dari kolom 'name'
        $slug = Str::slug($data['name']);
        
        // 2. Memastikan slug unik (menambahkan angka jika duplikasi)
        $originalSlug = $slug;
        $count = 1;
        while (Category::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }
        
        // 3. --- PEMBUATAN RECORD DI DATABASE ---
        $category = Category::create([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'slug' => $slug, // <-- MENAMBAHKAN SLUG OTOMATIS
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Category created successfully',
            'data' => $category,
        ], 201);
    }

    /**
     * GET /api/Category/{id}
     * Menampilkan detail kategori berdasarkan ID.
     */
    public function show($id): JsonResponse
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Category not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Category retrieved successfully',
            'data' => $category,
        ], 200);
    }

    /**
     * PUT /api/Category/{id}
     * Update kategori yang sudah ada.
     */
    public function update(Request $request, $id): JsonResponse
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Category not found',
            ], 404);
        }

        $data = $request->all();

        // Validasi Name jika ada
        if (isset($data['name'])) {
            if (empty($data['name'])) {
                return $this->validationErrorResponse('Name is Required');
            }
            if (strlen($data['name']) > 255) {
                return $this->validationErrorResponse('Name may not be greater than 255 characters.');
            }

            // Update slug jika name berubah
            $slug = Str::slug($data['name']);
            $originalSlug = $slug;
            $count = 1;
            
            // Pastikan slug unik, kecuali milik kategori yang sedang diupdate
            while (Category::where('slug', $slug)->where('id', '!=', $id)->exists()) {
                $slug = $originalSlug . '-' . $count++;
            }
            
            $category->slug = $slug;
        }

        // Update data
        if (isset($data['name'])) {
            $category->name = $data['name'];
        }
        if (isset($data['description'])) {
            $category->description = $data['description'];
        }

        $category->save();

        return response()->json([
            'success' => true,
            'message' => 'Category updated successfully',
            'data' => $category,
        ], 200);
    }

    /**
     * DELETE /api/Category/{id}
     * Menghapus kategori berdasarkan ID.
     */
    public function destroy($id): JsonResponse
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Category not found',
            ], 404);
        }

        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Category deleted successfully',
        ], 200);
    }
    
    /**
     * Helper untuk membuat response error validasi (422).
     */
    public function validationErrorResponse($message): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => 'Validation failed.',
            'errors' => $message,
        ], 422);
    }
}