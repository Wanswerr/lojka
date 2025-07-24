<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification; // Use a classe de notificação correta

class NotificationController extends Controller
{
    /**
     * Marca uma notificação como lida e redireciona para o link original.
     */
    public function markAsRead(DatabaseNotification $notification)
    {
        // Marca a notificação específica como lida
        $notification->markAsRead();

        // Redireciona para o link contido na notificação
        return redirect($notification->data['link'] ?? route('admin.dashboard'));
    }
}