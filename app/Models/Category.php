<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = true;

    protected $fillable = [
        'id',
        'name',
        'description',
        'slug', 
    ];

    /**
     * Relasi ke Product
     * Setiap Category has many Products
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }
}