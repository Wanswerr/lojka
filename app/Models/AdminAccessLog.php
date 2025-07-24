<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminAccessLog extends Model
{
    use HasFactory;

    /**
     * Os atributos que podem ser preenchidos em massa.
     */
    protected $fillable = [
        'admin_id',
        'ip_address',
        'action',
    ];

    /**
     * Define o relacionamento: um log pertence a um admin.
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}