<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'status', 'total'];

    // Relacionamento: Um pedido pertence a um usuário (cliente)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relacionamento: Um pedido tem muitos itens
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}