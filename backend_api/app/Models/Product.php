<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'slug',
        'price',
        'stock',
        'image',
    ];

    /**
     * Relasi ke Category
     * Setiap Product belongs to satu Category
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
