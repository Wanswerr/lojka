<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EmailTemplate;
use App\Models\EmailTemplateType; // Importe o novo model

class EmailTemplateSeeder extends Seeder
{
    public function run(): void
    {
        // Pega o ID do tipo "Confirmação de Pedido" que criamos no outro seeder
        $orderConfirmationType = EmailTemplateType::where('type_key', 'order_confirmation')->first();

        // Se o tipo existir, cria um template padrão para ele
        if ($orderConfirmationType) {
            EmailTemplate::updateOrCreate(
                [
                    // Condições para encontrar o registro
                    'email_template_type_id' => $orderConfirmationType->id,
                    'name' => 'Padrão de Confirmação de Pedido',
                ],
                [
                    // Dados para inserir ou atualizar
                    'subject' => 'Seu pedido #{{ NUMERO_PEDIDO }} foi confirmado!',
                    'body_html' => '<p>Olá, {{ NOME_CLIENTE }}!</p><p>Obrigado por sua compra. Seu pedido <strong>#{{ NUMERO_PEDIDO }}</strong> foi recebido e está sendo processado.</p>'
                ]
            );
        }

        // Exemplo para um segundo tipo
        $shippingType = EmailTemplateType::where('type_key', 'shipping_notification')->first();
        if ($shippingType) {
            EmailTemplate::updateOrCreate(
                [
                    'email_template_type_id' => $shippingType->id,
                    'name' => 'Padrão de Notificação de Envio',
                ],
                [
                    'subject' => 'Boas notícias! Seu pedido #{{ NUMERO_PEDIDO }} foi enviado.',
                    'body_html' => '<p>Olá, {{ NOME_CLIENTE }}!</p><p>Seu pedido <strong>#{{ NUMERO_PEDIDO }}</strong> já está a caminho.</p>'
                ]
            );
        }
    }
}