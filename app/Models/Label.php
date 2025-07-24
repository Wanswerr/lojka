<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Label extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'color'];

    /**
     * Os Produtos que pertencem a este Rótulo.
     */
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}