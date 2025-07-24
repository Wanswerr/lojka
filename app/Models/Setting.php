<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $primaryKey = 'key'; // Define 'key' como a chave primária
    public $incrementing = false;  // Informa que a chave primária não é auto-incremento
    protected $keyType = 'string'; // Informa que a chave primária é uma string

    public $timestamps = false; // Nossa tabela de settings não tem colunas de timestamp

    protected $fillable = ['key', 'value']; // Define os campos preenchíveis
}