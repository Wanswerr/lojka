<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // --- MÉTRICAS PRINCIPAIS ---
        // Apenas pedidos com status 'paid' (pago) devem contar para a receita.
        $totalRevenue = Order::where('status', 'paid')->sum('total');
        $totalOrders = Order::where('status', 'paid')->count();
        $totalCustomers = User::has('orders')->count(); // Conta usuários que fizeram pelo menos 1 pedido
        $activeProducts = Product::where('is_active', true)->count();

        // --- DADOS PARA O GRÁFICO "VISÃO GERAL DAS VENDAS" ---
        // Vendas dos últimos 30 dias, agrupadas por dia
        $salesOverTime = Order::where('status', 'paid')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get([
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total) as daily_total')
            ])
            ->pluck('daily_total', 'date');

        // --- DADOS PARA OS TOP 5 ---
        // Top 5 Produtos mais vendidos (baseado na quantidade vendida em itens de pedidos pagos)
        $topProducts = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', '=', 'paid')
            ->select('products.name', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->groupBy('products.name')
            ->orderBy('total_sold', 'desc')
            ->limit(5)
            ->get();

        // Vendas por Categoria
        $salesByCategory = DB::table('categories')
            ->join('product_category', 'categories.id', '=', 'product_category.category_id')
            ->join('order_items', 'product_category.product_id', '=', 'order_items.product_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'paid')
            ->select('categories.name', DB::raw('SUM(order_items.price * order_items.quantity) as category_revenue'))
            ->groupBy('categories.name')
            ->orderBy('category_revenue', 'desc')
            ->limit(5)
            ->get();

        // --- PEDIDOS RECENTES ---
        $recentOrders = Order::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalRevenue',
            'totalOrders',
            'totalCustomers',
            'activeProducts',
            'salesOverTime',
            'topProducts',
            'salesByCategory',
            'recentOrders'
        ));
    }
}