<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $fillable = ['admin_id', 'message', 'link', 'read_at'];
    protected $casts = ['read_at' => 'datetime'];

    public function admin() { return $this->belongsTo(Admin::class); }
}