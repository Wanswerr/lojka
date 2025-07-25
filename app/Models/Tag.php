<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    /**
     * Os Produtos que pertencem a esta Tag.
     */
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}