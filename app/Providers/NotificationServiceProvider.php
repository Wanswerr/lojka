<?php
namespace App\Providers;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
use App\Models\Setting;

class NotificationServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Compartilha os dados com uma view específica (o cabeçalho)
        View::composer('admin.partials.header', function ($view) {
            if (Auth::guard('admin')->check()) {
                $admin = Auth::guard('admin')->user();

                // O Laravel agora nos dá essas coleções prontas!
                $notifications = $admin->unreadNotifications()->take(5)->get();
                $unreadCount = $admin->unreadNotifications()->count();

                $view->with('notifications', $notifications)->with('unreadCount', $unreadCount);
            }
        });
    }
}