<?php
namespace App\Notifications;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewOrderPaid extends Notification
{
    use Queueable;
    private $order;

    public function __construct($order) { $this->order = $order; }
    public function via(object $notifiable): array { return ['database']; }

    public function toDatabase(object $notifiable): array
    {
        return [
            'message' => 'Novo pedido pago: #' . $this->order->id,
            'link' => route('admin.orders.show', $this->order->id),
        ];
    }
}