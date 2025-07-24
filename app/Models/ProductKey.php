<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // <-- Adicione esta linha
use Illuminate\Database\Eloquent\Model;

class ProductKey extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'key_data', 'status', 'order_item_id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

        public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }
}