<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class EmailTemplate extends Model
{
    use HasFactory;
    // Remova 'type' e adicione 'email_template_type_id'
    protected $fillable = ['name', 'subject', 'body_html', 'email_template_type_id'];

    // Adicione o relacionamento inverso
    public function emailTemplateType()
    {
        return $this->belongsTo(EmailTemplateType::class);
    }

        public function products()
    {
        return $this->hasMany(Product::class);
    }
}