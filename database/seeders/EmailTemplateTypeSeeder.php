<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EmailTemplateType;

class EmailTemplateTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['name' => 'Confirmação de Pedido', 'type_key' => 'order_confirmation'],
            ['name' => 'Notificação de Envio', 'type_key' => 'shipping_notification'],
            ['name' => 'Entrega de Produto Digital', 'type_key' => 'product_delivery'],
            ['name' => 'Comunicação Geral', 'type_key' => 'general_communication'],
            ['name' => 'Notificação Geral', 'type_key' => 'general_notification'],
            ['name' => 'Marketing e Promoções', 'type_key' => 'marketing_promo'],
            ['name' => 'Redefinição de Senha', 'type_key' => 'password_reset'],
        ];
        foreach ($types as $type) {
            EmailTemplateType::updateOrCreate(['type_key' => $type['type_key']], $type);
        }
    }
}