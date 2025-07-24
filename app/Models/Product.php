<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'type',
        'slug',
        'description',
        'image_path',
        'price',
        'is_active',
        'email_template_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    # A Categoria ou Categorias que pertencem ao Produto.
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_category')
                    ->withPivot('position') // Informa que queremos aceder à coluna 'position'
                    ->orderBy('pivot_position', 'asc'); // Ordena por essa coluna
    }

    #As Tags que pertencem ao Produto.
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    # Os Rótulos que pertencem ao Produto
    public function labels()
    {
        return $this->belongsToMany(Label::class);
    }

        public function deliveryEmailTemplate()
    {
        return $this->belongsTo(EmailTemplate::class, 'email_template_id');
    }

        public function keys()
    {
        return $this->hasMany(ProductKey::class);
    }

    // Adicione este método "mágico" (Acessor)
    public function getAvailableKeysCountAttribute()
    {
        // Verifica se o produto é do tipo que tem chaves
        if ($this->type === 'key' || $this->type === 'account') {
            // Conta as chaves associadas a este produto ($this->keys())
            // onde o status é 'available'.
            return $this->keys()->where('status', 'available')->count();
        }

        // Para qualquer outro tipo de produto, o estoque é 0.
        return 0;
    }
}