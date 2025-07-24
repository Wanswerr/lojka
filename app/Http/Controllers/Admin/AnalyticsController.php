<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
        // Pega o período da URL, o padrão é 'last_30_days'
        $period = $request->query('period', 'last_30_days');
        $startDate = null;
        $endDate = now();

        switch ($period) {
            case 'today':
                $startDate = now()->startOfDay();
                break;
            case 'last_7_days':
                $startDate = now()->subDays(6)->startOfDay();
                break;
            case 'this_month':
                $startDate = now()->startOfMonth();
                break;
            case 'last_30_days':
            default:
                $startDate = now()->subDays(29)->startOfDay();
                break;
        }

        // --- MÉTRICAS COM FILTRO DE PERÍODO ---
        $revenue = Order::where('status', 'paid')
                        ->whereBetween('created_at', [$startDate, $endDate])
                        ->sum('total');

        $ordersCount = Order::where('status', 'paid')
                            ->whereBetween('created_at', [$startDate, $endDate])
                            ->count();
                            
        $newCustomersCount = User::whereBetween('created_at', [$startDate, $endDate])->count();


        return view('admin.analytics.index', compact(
            'revenue',
            'ordersCount',
            'newCustomersCount',
            'period' // Passa o período atual para a view
        ));
    }
}