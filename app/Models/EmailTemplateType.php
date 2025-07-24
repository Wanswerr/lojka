<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailTemplateType extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'type_key'];

    public function emailTemplates()
    {
        return $this->hasMany(EmailTemplate::class);
    }
}