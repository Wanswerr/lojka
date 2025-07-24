<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    /**
     * As permissões que pertencem a este Papel.
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    /**
     * Os Admins que possuem este Papel.
     */
    public function admins()
    {
        return $this->belongsToMany(Admin::class);
    }
}