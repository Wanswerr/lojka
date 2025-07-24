<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
    protected $fillable = ['order_id', 'product_id', 'quantity', 'price'];

    // Relacionamento: Um item de pedido pertence a um produto
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

        public function deliveredKey()
    {
        // Um item de pedido tem uma chave.
        return $this->hasOne(ProductKey::class);
    }

}