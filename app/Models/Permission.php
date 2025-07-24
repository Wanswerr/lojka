<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    /**
     * Os papéis (roles) que possuem esta permissão.
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}