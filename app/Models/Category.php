<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'image_path'];

    /**
     * Os Produtos que pertencem a esta Categoria.
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_category');
    }
}